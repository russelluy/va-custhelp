<?php

use RightNow\Internal\Libraries\Widget\Registry,
    RightNow\Internal\Utils\Widgets as WidgetsInternal,
    RightNow\Utils\Widgets as WidgetsExternal;

require_once(__DIR__ . '/CPTestCase.php');

class WidgetTestCase extends CPTestCase
{
    /**
     * Path to the widget being tested
     * @var string
     */
    public $testingWidget;

    /**
     * Mock \RightNow\Controllers\Base object.
     * If this property is defined then it's used
     * as the `$this->CI` instance of the widget
     * under test.
     * @var object
     */
    public $mockCI;

    /**
     * Instance of the widget being tested
     * @object
     */
    public $widgetInstance;

    /**
     * Create and return an instance of the widget being tested.
     * @return object Instance of the widget controller
     */
    function createWidgetInstance(array $attributes = array())
    {
        return $this->widgetInstance = $this->getWidgetInstance($attributes);
    }

    /**
     * Returns an instance of a widget controller
     * @param array $attributes Attributes to pass to the widget (optional)
     * @return object Instance of the widget controller
     */
    function getWidgetInstance(array $attributes = array())
    {
        if (!$this->testingWidget) {
            throw new \Exception("This object (" . get_class($this) . ") must have a testingWidget property set to the widget path of the widget being tested");
        }
        if (!$widget = Registry::getWidgetPathInfo($this->testingWidget))
            throw new \Exception("Invalid widget path '$this->testingWidget'");

        $meta = WidgetsInternal::getWidgetInfo($widget, true);
        if (!is_array($meta))
            throw new \Exception("Unable to get widget info for '$this->testingWidget'");

        $widgetClass = WidgetsExternal::getWidgetController($meta['controller_path'], $meta['extends_info']['controller']);
        $meta = WidgetsExternal::convertAttributeTagsToValues($meta, array('validate' => true, 'eval' => true, 'omit' => array('name', 'description')));
        if (!class_exists($widgetClass))
            throw new \Exception("Unable to find class '$widgetClass'");

        $instance = new $widgetClass($meta['attributes']);
        $instance->CI = $this->mockCI ?: $this->CI ?: get_instance();
        $instance->CI->clientLoader = new \RightNow\Libraries\ClientLoader(new \RightNow\Internal\Libraries\ProductionModeClientLoaderOptions());
        $this->setWidgetAttributes($attributes, $instance);
        $instance->setPath($widget->relativePath);
        $instance->setHelper();

        return $instance;
    }

    /**
     * Returns an anonymous function that's used to invoke the specified method using a variable-length argument list.
     * This is generally used for private or protected methods as the accessibility is enabled via ReflectionMethod. This
     * will work with both static and non-static methods.
     * @param string $methodName The name of the method to invoke
     * @param object $instance An instance of the object containing the method to call
     * @return function
     */
    function getWidgetMethod($methodName, &$instance = null)
    {
        if ($instance === null)
            $instance = $this->widgetInstance;

        if ($instance === null)
            throw new Exception("No widget instance!");

        $method = new \ReflectionMethod(get_class($instance), $methodName);
        $method->setAccessible(true);

        return function() use ($instance, $method) {
            return $method->invokeArgs($instance, func_get_args());
        };
    }

    /**
     * Returns the output from a function. Generally functions used with AJAX echo content, which
     * this wrapper will capture and return
     * `makeRequest` is used to avoid 'headers already sent' errors, as `echoJSON` and `renderJSON` set Content Length and Type headers.
     * @param string $methodName The name of the method to invoke
     * @param array|string $parameters Array of key/value pairs, or a url parameter string
     * @param bool $jsonDecode Whether the return data should be JSON decoded
     * @param object $instance Widget instance
     * @param bool $addCPSessionCookie Whether to include cp_session cookie in request
     * @return string
     */
    function callAjaxMethod($methodName, $parameters, $jsonDecode = true, &$instance = null, $addCPSessionCookie = false)
    {
        if (!$parameters['w_id']) {
            // Required by `makeRequest`
            $widgetData = $this->getWidgetData($instance);
            $parameters['w_id'] = $widgetData['info']['w_id'];
        }
        $response = $this->makeRequest("/ci/ajax/widget/{$this->testingWidget}/$methodName", array(
            'post' => is_array($parameters) ? $this->postArrayToParams($parameters) : $parameters,
            'cookie' => $addCPSessionCookie ? 'cp_session=' . get_instance()->sessionCookie : null,
        ));
        return $jsonDecode ? json_decode($response) : $response;
    }

    /**
     * Sets attributes on an instance of a widget
     * @param array $attributes The attributes to set on the widget instance
     * @param object $instance Widget instance
     */
    function setWidgetAttributes(array $attributes, &$instance = null)
    {
        if ($instance === null)
            $instance = $this->widgetInstance;

        if ($instance === null)
            throw new Exception("No widget instance!");

        $instance->setAttributes($attributes);
        $instance->initDataArray();
    }

    /**
     * Calls widgets getData() method and returns the widgets data array.
     * @param object $instance Widget instance
     * @return array
     */
    function getWidgetData(&$instance = null)
    {
        if ($instance === null)
            $instance = $this->widgetInstance;

        if ($instance === null)
            throw new Exception("No widget instance!");
        $instance->getData();
        return $instance->getDataArray();
    }
}
