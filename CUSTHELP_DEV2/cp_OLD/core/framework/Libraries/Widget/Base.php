<?php

namespace RightNow\Libraries\Widget;

use RightNow\Utils\Text,
    RightNow\Utils\Config,
    RightNow\Internal\Libraries\Widget\ViewPartials\Handler as ViewPartialHandler;

/**
 * Base class for all widgets, both custom and standard. Every widget must extend from this class.
 */
abstract class Base extends \RightNow\Internal\Libraries\Widget\Base
{
    public $js = array();
    public $attrs = array();
    public $info = array();
    public $parms = array();
    public $ajaxHandlers = array();
    public $CI;
    public $data;
    public $instanceID;
    public $path;
    public $classList;
    private $partialStack = array();

    /**
     * The actual view code of the widget.
     * @internal
     */
    protected $viewContent;

    public function __construct($manifestAttributes)
    {
        parent::__construct($manifestAttributes);
        $this->setClassList();
    }

    /**
     * Magic get method used to throw errors when people try to access a non-existant property.
     * @param string $name Invalid property name
     * @return void
     * @throws \Exception Always since property doesn't exist
     */
    public function __get($name)
    {
        throw new \Exception("$name is not accessible.");
    }

    /**
     * Magic get method used to throw errors when people try to set a non-existant property.
     * @param string $name Invalid property name
     * @param mixed $value Value to set
     * @return void
     * @throws \Exception Always since property doesn't exist
     */
    public function __set($name, $value)
    {
        throw new \Exception("$name is not accessible.");
    }

    /**
     * Empty getData function in case custom widget extends from Base and
     * calls parent::getData()
     * @return void
     */
    public function getData(){}

    /**
     * Allows a widget to push content into the page head
     * @param string $content The content to add to the end of the page head tag
     * @return void
     */
    public function addHeadContent($content)
    {
        $this->CI->clientLoader->addHeadContent("$content\n");
    }

    /**
     * Allows a widget to add a JavaScript file to the page. This
     * will de-duplicate file paths so each file will only be included
     * once.
     * @param string $filePath The fully qualified path to the included file
     * @param string $type The classification of file to include
     * @param string $attributes Additional script tag attributes
     * @return string|null The script tag for the included file if it hasn't already been added
     */
    public function addJavaScriptInclude($filePath, $type='additional', $attributes='')
    {
        return $this->CI->clientLoader->addJavaScriptInclude($filePath, $type, $attributes);
    }

    /**
     * Loads the JavaScript resource(s) specified by $urls. Resource will be loaded asynchronously by default.
     * @param string|array $urls The path to the JS being loaded, or a list of paths.
     * @param array $options Options that control whether the resource is fetched asynchronously
     *                       as well as other options that can be passed along to `YUI.Get.js` such as a callback.
     *                       If options is empty, or only contains the 'async' attribute, the JS resource will be loaded via the `script` tag.
     *                       Specifying any other options, such as `callback` will result in loading the resource via `YUI.Get.js`.
     * @return string The code used to load the resource, either via the `script` tag or `YUI.Get.js`
     */
    public function loadJavaScriptResource($urls, array $options = array('async' => true)) {
        return $this->CI->clientLoader->loadJavaScriptResource($urls, $options);
    }

    /**
     * Adds the contents of a file or literal code to the end of the page.
     * @param string $pathOrCode Either the path to a file or literal JavaScript code
     * @param bool $isCode Denotes if content is literal code or the path to a file
     * @return void
     */
    public function addJavaScriptInline($pathOrCode, $isCode = false)
    {
        $this->CI->clientLoader->addJavaScriptInline($pathOrCode, $isCode);
    }

    /**
     * Allows a widget to add a reference to a CSS file to the page. This will de-duplicate file
     * paths so each file will only be included once.
     * @param string $path The path to the included file.
     * @return void
     */
    public function addStylesheet($path)
    {
        $this->CI->clientLoader->addStylesheet($path);
    }

    /**
     * Renders a view partial. Generally used inside of a widget's view.
     * @param string $viewName The name of the view partial to load. Must match filename.
     * @param array $data Array of fields to be loaded into the view partial. Restricted field names: 'filepath'.
     * @return bool|string View partial or false on error.
     */
    public function render($viewName, array $data = array()) {
        try {
            $viewHandler = new ViewPartialHandler($viewName, \RightNow\Utils\Widgets::getFullWidgetVersionDirectory($this->getPath()));
        }
        catch (\Exception $e) {
            echo $this->reportError($e->getMessage());
            return false;
        }

        $viewPartial = $viewHandler->view;
        if (array_search($viewName, $this->partialStack) !== false) {
            echo $this->reportError(sprintf(Config::getMessage(CIRCULAR_RENDER_LOOP_DETECTED_PCT_S_MSG), $viewName));
            return false;
        }
        if (($viewContent = $viewPartial->getContents()) === false) {
            echo $this->reportError(sprintf(Config::getMessage(COULDNT_PARTIAL_FILE_PCT_S_LBL), $viewName));
            return false;
        }
        if ($badKeysFound = $viewPartial::invalidPartialDataFound($data)) {
            echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(DISALLOWED_KEY_FND_VIEW_PARTIAL_LBL), $badKeysFound));
            return false;
        }

        $this->partialStack []= $viewName;

        $rendered = ($viewPartial::$canSelfRender)
            ? $viewPartial->render($viewContent, $data)
            : $this->renderPartial($viewContent, $data);

        array_pop($this->partialStack);

        return $rendered;
    }

    /**
     * Sets the input field name of an Input type widget so that constraints added in the
     * `$this->data['constraints']` array are correctly associated with the field.
     * @param string $inputName The name attribute for an input widget
     * @return void
     */
    public function setInputName($inputName) {
        $this->inputName = $inputName;
    }

    /**
     * Return the list of all applied constraints
     * @return The list of constraints
     */
    public static function getFormConstraints() {
        return self::$serverConstraints;
    }

    /**
     * Reset the list of all constraints
     * @return void
     */
    public static function resetFormConstraints() {
        self::$serverConstraints = array();
    }

    /**
     * Initializes the widgets data property.
     * @return array The widgets data member
     * @internal
     */
    public function initDataArray()
    {
        return $this->data = array(
            'attrs' => $this->getCollapsedAttributes(),
            'info' => $this->getInfo(),
            'js' => $this->getJS(),
            'name' => $this->instanceID,
            'constraints' => array()
        );
    }

    /**
     * Returns the widgets data property
     * @return array The widgets data property
     */
    public function getDataArray()
    {
        return $this->data;
    }

    /**
     * Returns a specific item out of the widgets js property, or the entire
     * array if no item is specified
     *
     * @param string|null $item Key to retrieve
     * @return mixed The specific item requested or the entire array.
     */
    public function getJS($item = null)
    {
        return ($item === null) ? $this->js : $this->js[$item];
    }

    /**
     * Sets the function use to get the widgets view. Only used in production mode.
     *
     * @param string $value The name of the function to get the widgets view.
     * @return void
     * @internal
     */
    public function setViewFunctionName($value)
    {
        parent::setViewFunctionName($value);
    }

    /**
     * Sets the ajaxHandlers property. Only sets the handlers which have corresponding defined attributes.
     * @param array $handlers Array of handlers
     * @return array|null List of valid ajax handlers that were passed in or null if no valid handlers were processed
     * @internal
     */
    public function setAjaxHandlers(array $handlers)
    {
        foreach($handlers as $handlerAttributeName => $handlerDetails){
            //Ensure that the handler attribute actually exists on the widget. If not, then
            //remove that handler from the array
            if(!array_key_exists($handlerAttributeName, $this->attrs)){
                unset($handlers[$handlerAttributeName]);
            }
        }
        if(count($handlers)){
            $this->hasCalledAjaxHandlerSetter = true;
            return $this->ajaxHandlers = $handlers;
        }
    }

    /**
    * Gets the ajaxHandlers property.
    * @return array List of AJAX handlers for this widget.
    */
    public function getAjaxHandlers()
    {
        return $this->ajaxHandlers;
    }

    /**
     * Returns an item specified from the widget parameter array, or
     * returns the entire array.
     * @param string $key The specific item to retrieve
     * @return mixed A specific item or the entire array
     */
    public function getParameter($key = null)
    {
        return ($key === null) ? $this->parms : $this->parms[$key];
    }

    /**
     * Sets an item within the widget parameter array for documentation purposes.
     * @param string $key The name of the item
     * @param mixed $value The value of the item
     * @return void
     * @internal
     */
    public function setParameter($key, $value)
    {
        $this->parms[$key] = $value;
    }

    /**
     * Returns an item specified from the widget info array, or
     * returns the entire array if no item was specified
     * @param string|null $key The specific item to retrieve
     * @return mixed A specific item or the entire array
     */
    public function getInfo($key = null)
    {
        return ($key === null) ? $this->info : $this->info[$key];
    }

    /**
     * Sets an item within the widget info array.
     * @param string $key The name of the item
     * @param mixed $value The value of the item
     * @return void
     * @internal
     */
    public function setInfo($key, $value = null)
    {
        if(is_array($key))
        {
            foreach($key as $name => $value)
                $this->info[$name] = $value;
        }
        else
        {
            $this->info[$key] = $value;
        }
    }

    /**
     * Returns an item specified from the widget attribute array, or
     * returns the entire array.
     * @param string $key The specific item to retrieve
     * @return Mixed A specific item or the entire array
     */
    public function getAttribute($key = null)
    {
        return ($key === null) ? $this->attrs : $this->attrs[$key]->value;
    }

    /**
     * Returns the widget calling path (path to view, not controller)
     * @return string Path to current widget instance
     */
    public function getPath()
    {
        return $this->path;
    }
    /**
     * Sets the widget calling path (path to view, not controller)
     * @param string $path Path to the widget view.
     * @return void
     * @internal
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Sets the view content for the widget
     * @param string $content The widget view content
     * @return void
     * @internal
     */
    public function setViewContent($content)
    {
        $this->viewContent = $content;
    }

    /**
     * Intermediate function to display a widget error to the page and also
     * add a entry to the development header.
     * @param string $errorMessage The error message to display
     * @param bool $severe If true, the message is displayed as an error in the development header; if false, the message is
     * displayed as a warning.
     * @return string The error message, formatted with the widget path.
     * @throws \Exception If no error message is provided
     */
    public function reportError($errorMessage, $severe = true)
    {
        if (strlen($errorMessage) === 0) {
            throw new \Exception("It looks like you're doing it wrong.  \$errorMessage shouldn't be an empty string.");
        }
        return self::widgetError($this->path, $errorMessage, $severe);
    }

    /**
     * Return a formatted error message.
     * @param string $widgetPath The path to the widget where the error occurred
     * @param string $errorMessage The error message to display to the user
     * @param bool $severe If true, the message is displayed as an error in the development header; if false, the message is
     * displayed as a warning.
     * @return string The formatted error message
     * @internal
     */
    public static function widgetError($widgetPath, $errorMessage, $severe = true)
    {
        return parent::widgetError($widgetPath, $errorMessage, $severe);
    }

    /**
     * Returns all widget attributes in associative array format
     * @return array The widget attributes in an array
     */
    protected function getCollapsedAttributes()
    {
        $attributes = array();
        foreach($this->attrs as $key => $value)
            $attributes[$key] = $value->value;
        return $attributes;
    }

    /**
     * Sets a new instance for the `classList` property
     * @return void
     * @internal
     */
    private function setClassList() {
        $classes = array();
        foreach ((array(get_class($this)) + class_parents($this)) as $namespacedClass) {
            if ($namespacedClass === 'RightNow\Libraries\Widget\Base') break;
            $classes []= 'rn_' . substr($namespacedClass, (strrpos($namespacedClass, '\\') ?: -1) + 1);
        }
        $this->classList = new ClassList($classes);
    }
}

/**
 * Class used by widgets to define attributes on the widget. Contains all the restrictions on the
 * attribute such as min/max length, size, etc.
 */
class Attribute
{
    public $name;
    public $value;
    public $type;
    public $default;
    public $tooltip;
    public $description;
    public $options = array();
    public $min;
    public $max;
    public $length;
    public $optlistId;
    public $required = false;
    public $inherited = false;
    public $displaySpecialCharsInTagGallery = false;

    /**
     * Constructor
     *
     * @param array $properties Array of properties to set when instance is created.
     */
    public function __construct(array $properties = array())
    {
        foreach($properties as $key => $value){
            $this->$key = $value;
        }
        $this->value = $this->value ?: $this->default;
        $this->tooltip = $this->description;
    }


    /**
     * Magic method called when var_export is called on attribute.
     *
     * @param array $state Current state of attribute in an associative array.
     *
     * @return Attribute New Attribute instance
     * @internal
     */
    public static function __set_state(array $state)
    {
        return new Attribute($state);
    }

    /**
     * Returns the code representation of the attribute. Used when writing out the attribute objects to the
     * optimizedWidget file during the deploy operation.
     * @return string Widget attribute converted into string structure
     * @internal
     */
    public function toString(){
        $stateCode = "\\RightNow\\Libraries\\Widget\\Attribute::__set_state(array(\n";
        foreach($this as $key => $value){
            //Don't write out values that are the same as the defaults
            if($key === 'displaySpecialCharsInTagGallery' ||
                ($key === 'required' && $value === false) ||
                ($key === 'options' && count($value) === 0) ||
                ($key !== 'value' && $key !== 'default' && $value === null))
            {
                continue;
            }
            if($key === 'options'){
                $stateCode .= "'$key' => array(";
                for($i = 0; $i < count($value); $i++){
                    $stateCode .= "$i => '{$value[$i]}', ";
                }
                $stateCode .= "),\n";
            }
            else if(in_array($key, array('name', 'description', 'tooltip', 'default', 'value', 'optlistId'))){
                $stateCode .= "'$key' => $value,\n";
            }
            else{
                $stateCode .= "'$key' => " . var_export($value, true) . ",\n";
            }
        }
        return "$stateCode))";
    }
}

/**
 * Object used to document URL parameters which a widget responds to. Contains information about these
 * URL parameters such as their description and an example.
 */
class UrlParameter
{
    public $name;
    public $key;
    public $required;
    public $description;
    public $example;

    /**
     * Constructor
     *
     * @param string $name Readable name of URL parameter
     * @param string $key Key of parameter used in the URL
     * @param bool $required Whether the parameter is required in order for the widget to display
     * @param string $description Description of the parameter
     * @param string $example Sample of how the attribute would look in the URL
     */
    public function __construct($name, $key, $required, $description, $example)
    {
        $this->name = $name;
        $this->key = $key;
        $this->required = $required;
        $this->description = $description;
        $this->example = $example;
    }
}

/**
 * Stores top-level HTML class names for the widget. Provides methods for adding, removing, toggling,
 * and determining whether a class is currently-stored. Can be accessed using `$this->classList` from
 * within a widget.
 */
class ClassList {
    private $classes = array();

    /**
     * Constructor.
     * May be passed an array of classes or any number of classes.
     */
    public function __construct() {
        $numArgs = func_num_args();
        $args = func_get_args();

        if ($numArgs === 1 && is_array($args[0])) {
            $toFill = $args[0];
        }
        else if ($numArgs > 0) {
            $toFill = $args;
        }

        if ($toFill) {
            foreach ($toFill as $class) {
                if (is_string($class) && ($class = trim($class))) {
                    $this->classes []= $class;
                }
            }
        }
    }

    /**
     * Adds a class. Doesn't handle multiple, space-separated classes; use multiple
     * calls to #add to add multiple class names.
     * @param string $value Class to add
     * @return ClassList Current instance to allow for chaining
     */
    public function add($value) {
        if (!$this->contains($value) && ($value = trim($value))) {
            $this->classes []= $value;
        }
        return $this;
    }

    /**
     * Removes a class. Doesn't handle multiple, space-separated classes; use multiple
     * calls to #remove to remove multiple class names.
     * @param string $value Class to remove
     * @return ClassList Current instance to allow for chaining
     */
    public function remove($value) {
        if (($index = array_search(trim($value), $this->classes, true)) !== false) {
            unset($this->classes[$index]);
        }

        return $this;
    }

    /**
     * Adds the class if not present, removes it if present. Doesn't handle space-separated classes; use multiple
     * calls to #toggle to toggle multiple class names.
     * @param string $value Class to toggle
     * @return boolean True if the class was added, False if the class was removed
     */
    public function toggle($value) {
        if ($this->contains($value)) {
            $this->remove($value);
            return false;
        }
        $this->add($value);
        return true;
    }

    /**
     * Whether or not the classList contains a specified class.
     * @param string $value String class
     * @return boolean Whether the class list contains the specified $value
     */
    public function contains($value) {
        return in_array(trim($value), $this->classes);
    }

    /**
     * Converts the full list of CSS class names into a space separated string
     * @return string Space-separated classes
     */
    public function __toString() {
        return Text::joinOmittingBlanks(' ', $this->classes);
    }

    /**
    * Getter for `classes`.
    * @param string $name Name of property, classes
    * @return array Classes variable
    */
    public function __get($name) {
        if ($name === 'classes') {
            return $this->classes;
        }
    }
}
