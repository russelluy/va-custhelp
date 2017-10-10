<?php

namespace RightNow\Controllers;

use RightNow\Utils\Text;

/**
 * Ajax endpoint specifically used to deal with widgets which contain their own Ajax handler methods.
 */
final class Ajax extends Base{
    private $inspectedLoginExemption = false;

    /**
     * Generic handler for all widgets that want to define their own ajax
     * handling methods. Variables are widget path, plus handler method (ea. segment is a parameter)
     */
    public function widget(){
        list($method, $widgetPath) = $this->_getWidgetPath(func_get_args());
        // expecting something like standard/feedback/SiteFeedback/handlerMethod
        // TODO use a separator (\?\) to delimit widget path & GET parameters
        if(!Text::beginsWith($widgetPath, 'standard/') && !Text::beginsWith($widgetPath, 'custom/')){
            exit("The widget path $widgetPath is invalid");
        }
        $widgetID = $this->_getWidgetInstanceID($widgetPath);

        $stashedWidgetInfo = $this->_getStashedWidgetInfo($widgetPath, $widgetID);

        $widget = $this->_getWidget($widgetPath, $stashedWidgetInfo);

        $this->_callWidgetMethod(array(
            'widget' => array(
                'class' => $widget,
                'id'    => $widgetID,
                'path'  => $widgetPath,
                'info'  => $stashedWidgetInfo,
            ),
            'method' => $method,
            'params' => $_POST,
        ));
    }

    /**
     * Ensures user is allowed to view this data.
     * @internal
     */
    protected function _isContactAllowed() {
        if ($this->inspectedLoginExemption === false) {
            // Initially called by parent before #widget;
            // always return true since it's not yet known
            // whether the widget handler is exempt or not...
            return true;
        }
        // Called by parent after #_callWidgetMethod
        // has properly determined exemption status and
        // manually tells the parent to re-check
        return parent::_isContactAllowed();
    }

    /**
     * Extracts the widget path from the arguments. Ignores the session
     * parameter if it's present.
     *
     * @param array $args Each segment in the request URI after '/ci/ajax/'
     * @return array Array with the following items
     *  - 0 : String Name of the widget's method
     *  - 1 : String Relative widget path
     * @internal
     */
    private function _getWidgetPath(array $args) {
        if (($sessionIndex = array_search('session', $args)) !== false) {
            unset($args[$sessionIndex], $args[$sessionIndex + 1]);  // Session key & value
        }

        return array(
            array_pop($args),
            implode('/', $args),
        );
    }

    /**
     * Returns widget ajax info stored in memcache.
     * @param string $widgetPath Path to widget
     * @param int $widgetID Widget instance ID
     * @return array Array containing widget instance ID, handler method, clickstream mapping, and widget extension data
     */
    private function _getStashedWidgetInfo($widgetPath, $widgetID) {
        return \RightNow\Utils\Widgets::getWidgetAjaxInfo($widgetID, $widgetPath, $this->_getPageFromReferrer());
    }

    /**
     * Extracts the CP page path from the referring URL.
     * Returns null if the referrer is invalid (empty or an external site).
     * @return string|null Page path without any preceeding /app (e.g. "answers/list", "home") or null if referrer is invalid.
     * @internal
     */
    private function _getPageFromReferrer() {
        // Default to checking super special header for referrer first (IE + base tag + AJAX = FTL)
        $referrer = $_SERVER['HTTP_RNT_REFERRER'] ?: $_SERVER['HTTP_REFERER'];
        if (Text::stringContains($referrer, \RightNow\Utils\Url::getShortEufBaseUrl('sameAsRequest'))) {
            $referrer = Text::getSubstringAfter($referrer, '/app/');
            if ($referrer === false) {
                $referrer = 'home';
            }
            $segments = explode('/', $referrer);
            if ($pageSet = $this->getPageSetPath()) {
                $segments = array_merge(explode('/', $pageSet), $segments);
            }
            $resolved = $this->getPageFromSegments($segments);
            if ($resolved['found']) {
                return $resolved['page'];
            }
        }
    }

    /**
     * Returns the fully qualified widget controller class name, provided the widget path
     * @param string $widgetPath Path to the widget
     * @param array|null $stashedWidgetInfo Data about the widget including it's extension details
     * @return string Fully qualified widget controller class
     */
    private function _getWidget($widgetPath, $stashedWidgetInfo) {
        try {
            $className = \RightNow\Utils\Widgets::getWidgetController($widgetPath, $stashedWidgetInfo['extends']);
        }
        catch (\Exception $e) {
            //Error is handled below
        }

        if (!$className || !class_exists($className)) {
            exit("The widget path $widgetPath is invalid");
        }

        return $className;
    }

    /**
     * Executes the specified `$method` on the widget.
     * It's the widget method's responsibility to echo out a response.
     * @param array $details The necessary data to execute the method on
     *                       the widget:
     *                       - widget:
     *                           - info: [stashed widget info]
     *                           - class: widget classname
     *                           - id: widget's id
     *                           - path: relative path
     *                       - method: string method name
     *                       - params: array params to pass
     */
    private function _callWidgetMethod(array $details) {
        $widgetDetails = $details['widget'];
        $methodName = $details['method'];

        if (!$this->_widgetMethodExists($widgetDetails['class'], $methodName)) {
            exit("There is no handler method specified for {$widgetDetails['path']}!");
        }

        $this->_insertClickstreamAction($widgetDetails['info'], $methodName);
        $this->_enforceLoginRequirements($widgetDetails['info'], $methodName);

        if (!$this->_callStaticMethod($widgetDetails['class'], $methodName, $details['params'])) {
            $widget = $widgetDetails['class'];
            $widget = new $widget($widgetDetails['info']['attributes']);
            $this->_callInstanceMethod($widget, $methodName, $widgetDetails, $details['params']);
        }
    }

    /**
     * Retrieves the widget instance ID from POST data.
     * @param string $widgetPath Path to widget, only used for error reporting
     * @return int Widget instance ID
     */
    private function _getWidgetInstanceID($widgetPath) {
        $widgetID = $_POST['w_id'];
        if (!$widgetID && $widgetID !== '0') {
            exit("There's no widget instance id (w_id) specified for $widgetPath!");
        }
        if (Text::stringContains($widgetID, '_')) {
            $widgetID = (int) Text::getSubstringAfter($widgetID, '_');
        }
        return $widgetID;
    }

    /**
     * If the specified method is static, executes it.
     * @param string $widgetClass     Widget class name
     * @param string $method     Method to execute
     * @param array $postParams POST parameters to send
     * @return boolean             True if executed, False if not
     */
    private function _callStaticMethod($widgetClass, $method, array $postParams) {
        $reflection = new \ReflectionMethod($widgetClass, $method);

        if ($reflection->isStatic()) {
            $widgetClass::$method($postParams);
            return true;
        }

        return false;
    }

    /**
     * Executes the specified method.
     * @param object $widget Widget instance
     * @param string $method        Method name
     * @param array $widgetDetails Stashed widget info
     * @param array $params        Post params
     */
    private function _callInstanceMethod($widget, $method, array $widgetDetails, array $params) {
        $name = basename($widgetDetails['path']);
        $id = $widgetDetails['id'];
        $widget->setInfo(array(
            'name' => $name,
            'w_id' => $id,
        ));
        $widget->instanceID = "{$name}_{$id}";

        if ($widgetDetails['info']['nonDefaultAttrValues']) {
            $widget->setAttributes($widgetDetails['info']['nonDefaultAttrValues']);
        }

        $widget->setPath($widgetDetails['path']);
        $widget->initDataArray();

        $widget->$method($params);
    }

    /**
     * Makes sure that the specified method actually exists on the widget.
     * @param string $widgetClass Widget's class
     * @param string $method     Method name
     * @return  boolean True if the method exists, False otherwise
     */
    private function _widgetMethodExists($widgetClass, $method) {
        $classMethods = get_class_methods($widgetClass);

        return $method && $classMethods && \RightNow\Utils\Framework::inArrayCaseInsensitive($classMethods, $method);
    }

    /**
     * Inserts a clickstream action for the widget
     * @param array  $stashedWidgetInfo Stashed info
     * @param string $methodName        Method name
     * @return string The inserted action
     */
    private function _insertClickstreamAction($stashedWidgetInfo, $methodName) {
        $clickstream = new \RightNow\Hooks\Clickstream();

        if (!$stashedWidgetInfo || !$stashedWidgetInfo['clickstream'] || !($action = $stashedWidgetInfo['clickstream'][$methodName])) {
            $action = $methodName;
        }

        $clickstream->trackSession('normal', $action);

        return $action;
    }

    /**
     * Deals with login requirements and exemptions.
     * @param array  $stashedWidgetInfo Stashed info
     * @param string $methodName        Method name
     */
    private function _enforceLoginRequirements($stashedWidgetInfo, $methodName) {
        if ($stashedWidgetInfo && $stashedWidgetInfo['exempt_from_login_requirement'] && $stashedWidgetInfo['exempt_from_login_requirement'][$methodName]) {
            parent::_setMethodsExemptFromContactLoginRequired(array(
                $this->uri->router->fetch_method(),
            ));
        }

        $this->inspectedLoginExemption = true;
        parent::_ensureContactIsAllowed();
    }
}