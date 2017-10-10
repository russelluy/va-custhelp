<?php

use RightNow\Utils\Text,
    RightNow\Utils\FileSystem,
    RightNow\UnitTest\Helper,
    RightNow\Connect\v1_2 as ConnectPHP;

/**
 * Extends UnitTestCase and provides functionality for commonly-needed
 * test operations like reflection, logging in, and http requests.
 */
class CPTestCase extends UnitTestCase {
    /**
     * Y'know.
     * @var object
     */
    public $CI;
    /**
     * Name of the class being tested, including namespace.
     * Children are required to set this if using any
     * of the reflection methods.
     * @var string
     */
    public $testingClass;
    /**
     * Path to temporary directory
     * to write files for a test
     * @var string
     */
    public $testDir;
    /**
     * Temp variable for session when
     * session mocking is taking place
     * @var object
     */
    private $realSession;
    /**
     * Name of class where handler function is located
     * @var string
     */
    protected $hookEndpointClass;
    /**
     * relative file path to file where handler function
     * is located (eg. Models/tests/Contact.test.php)
     * @var string
     */
    protected $hookEndpointFilePath;
    /**
     * Variable to hold data for processing and verification in
     * tests that involve hooks.
     * @var object
     */
    protected static $hookData;
    /**
     * Generic error message used for holding the current hook
     * error.
     * @var string
     */
    protected static $hookErrorMsg = 'Error encountered calling hook';

    function __construct($label = false) {
        parent::__construct($label);
        $this->CI = get_instance();
    }

    function __destruct() {
        // Clean up after sloppy tests
        if ($this->testDir) {
            $this->eraseTempDir();
        }
        $this->unsetMockSession();
    }

    function run($reporter) {
        $this->setUpBeforeClass();
        parent::run($reporter);
        $this->tearDownAfterClass();
    }

    /**
     * Method that is called before any tests in a suite are ran
     */
    function setUpBeforeClass() {
    }

    /**
     * Method that is called after all tests in a suite are ran
     */
    function tearDownAfterClass() {
    }

    function setUp() {
        $hooks = Helper::getHooks();
        $this->oldHooksValue = $hooks->getValue();
        parent::setUp();
    }

    function tearDown() {
        $this->logOut();
        ConnectPHP\ConnectAPI::rollback();
        $this->unsetMockSession();
        $hooks = Helper::getHooks();
        $hooks->setValue($this->oldHooksValue);
        parent::tearDown();
    }

    /**
     * Potentially restrict tests to just those specified via the URL
     * @return array List of tests to run
     */
    function getTests(){
        $listOfAvailableTests = parent::getTests();
        $url = get_instance()->uri->uri_string();
        $listOfSubTests = trim(Text::getSubstringAfter($url, '/subtests/'));
        if($listOfSubTests){
            $listOfSubTests = explode(',', $listOfSubTests);
            foreach($listOfSubTests as $key => &$subTest){
                $subTest = trim($subTest);
                if(!in_array($subTest, $listOfAvailableTests)){
                    unset($listOfSubTests[$key]);
                    echo "Test '$subTest' does not exist as a test within " . $this->getLabel() . "<br/>";
                }
            }
            $listOfSkippedTests = array_diff($listOfAvailableTests, $listOfSubTests);
            $this->reporter->paintSkip(count($listOfSkippedTests) . " tests not run.");
            $listOfAvailableTests = $listOfSubTests;
        }
        return $listOfAvailableTests;
    }

    /**
     * Override the assert method to handle strings which do not contain %s. If the message doesn't
     * have an insertion point, just use the message directly.
     *
     * @param SimpleExpectation $expectation  Expectation subclass.
     * @param mixed $compare                  Value to compare.
     * @param string $message                 Message to display.
     * @return boolean                        True on pass
     */
    function assert($expectation, $compare, $message = '%s') {
        $outputMessage = Text::stringContains($message, '%s')
            ? sprintf($message, $expectation->overlayMessage($compare, $this->reporter->getDumper()))
            : $message;

        if ($expectation->test($compare)) {
            return $this->pass($outputMessage);
        }
        else {
            return $this->fail($outputMessage);
        }
    }

    /**
     * Because SimpleUnit's #assertTrue basically
     * asserts truthiness, and we want The Truth,
     * this overrides and asserts strict equal to boolean true.
     * @param bool $value Should be true
     */
    function assertTrue($value, $message = '%s should be TRUE') {
        return $this->assert(
            new IdenticalExpectation(true),
            $value,
            $message
        );
    }

    /**
     * Because SimpleUnit's #assertFalse basically
     * asserts falsiness, and we want The False,
     * this overrides and asserts strict equal to boolean false.
     * @param bool $value Should be false
     */
    function assertFalse($value, $message = '%s should be FALSE') {
        return $this->assert(
            new IdenticalExpectation(false),
            $value,
            $message
        );
    }

    /**
     * Because we override #assertTrue above, override #assertNull.
     * @param mixed $value Should be null
     */
    function assertNull($value, $message = '%s should be NULL') {
        return $this->assert(
            new IdenticalExpectation(null),
            $value,
            $message
        );
    }

    /**
     * Because we override #assertTrue above, override #assertNotNull.
     * @param mixed $value Should not be null
     */
    function assertNotNull($value, $message = '%s should not be NULL') {
        return $this->assert(
            new NotIdenticalExpectation(null),
            $value,
            $message
        );
    }

    /**
     * Assert that a string begins with another string.
     * @param  String $haystack String to search within
     * @param  String $needle   Substring that should start $haystack
     * @param  string $message  Optional error message
     */
    function assertBeginsWith($haystack, $needle, $message = '') {
        return $this->assertTrue(
            Text::beginsWith($haystack, $needle),
            $message ?: "String '$haystack' should start with '$needle'"
        );
    }

    /**
     * Assert that a string ends with another string.
     * @param  String $haystack String to search within
     * @param  String $needle   Substring that should end $haystack
     * @param  string $message  Optional error message
     */
    function assertEndsWith($haystack, $needle, $message = '') {
        return $this->assertTrue(
            Text::endsWith($haystack, $needle),
            $message ?: "String '$haystack' should end with '$needle'"
        );
    }

    /**
     * Assert that a string contains another string.
     * @param  String $haystack String to search within
     * @param  String $needle   Substring that should be contained in $haystack
     * @param  string $message  Optional error message
     */
    function assertStringContains($haystack, $needle, $message = '') {
        return $this->assertTrue(
            Text::stringContains($haystack, $needle),
            $message ?: "String '$haystack' should contain '$needle'"
        );
    }

    /**
     * Assert that a string doesn't contain another string.
     * @param  String $haystack String to search within
     * @param  String $needle   Substring that should not be contained in $haystack
     * @param  string $message  Optional error message
     */
    function assertStringDoesNotContain($haystack, $needle, $message = '') {
        return $this->assertFalse(
            Text::stringContains($haystack, $needle),
            $message ?: "String '$haystack' should not contain '$needle'"
        );
    }

    /**
     * Checks the boilerplate assertions that a given response object is valid and has no errors or warnings.
     * @param object $responseObject ResponseObject instance to check
     * @param string $returnValidationMethodOrClassName Method to run on the sub result property of the response object or object classname to verify. If a method
     *                                                  is passed it's expected to return true. If an instance is passed, it will be verified with assertIsA()
     * @param int $errorCount Number of errors to expect within the response object
     * @param int $warningCount Number of warnings to expect within the response object
     */
    function assertResponseObject($responseObject, $returnValidationMethodOrClassName = 'is_object', $errorCount = 0, $warningCount = 0){
        $this->assertIsA($responseObject, 'RightNow\Libraries\ResponseObject');
        if(is_callable($returnValidationMethodOrClassName)){
            $this->assertTrue($returnValidationMethodOrClassName($responseObject->result));
        }
        else{
            $this->assertIsA($responseObject->result, $returnValidationMethodOrClassName);
        }
        $this->assertSame($errorCount, count($responseObject->errors));
        $this->assertSame($warningCount, count($responseObject->warnings));
    }

    /**
     * Returns an anonymous function that's used to invoke the specified method using a variable-length argument list.
     * This is generally used for private methods as the accessibility is enabled via the ReflectionClass.
     * @param string $name name of the method to invoke
     * @param bool|array $isStatic Specify true if the method is static; if the method isn't static, and the class constructor
     * needs arguments passed to it, send an array of args
     * @return function
     * @throws \Exception If testingClass property is not set on test class
     */
    function getMethod($name, $isStatic = false) {
        if (!$this->testingClass) {
            throw new \Exception("This object (" . get_class($this) . ") must have a testingClass property set to the class name of the class being tested");
        }
        if ($isStatic === true) {
            $method = new \ReflectionMethod($this->testingClass, $name);
            $instance = null;
        }
        else {
            $class = new \ReflectionClass($this->testingClass);
            $instance = is_array($isStatic)
                ? $class->newInstanceArgs($isStatic)
                : $class->newInstance();
            $method = $class->getMethod($name);
        }

        $method->setAccessible(true);

        return function() use ($instance, $method) {
            return $method->invokeArgs($instance, func_get_args());
        };
    }

    /**
     * Returns a function that invokes the static method specified when called.
     * @param  string $name name of the method to invoke
     * @return function
     */
    function getStaticMethod($name) {
        return $this->getMethod($name, true);
    }

    /**
     * Provides quick reflection, usually so that the caller can access private
     * methods and properties in a single pass.
     *
     * If called with no args, then the \ReflectionClass of
     * the `$this->testingClass` class is returned.
     * Accepts any number of additional Strings that are names of properties or
     * methods to make accessible and return. Methods should be prefixed with 'method:'.
     * The return value is an array containing the mapped reflection class and the properties / methods.
     *
     * Example:
     *
     *          list($class, $someMethod, $privateVar) = reflect('method:someMethod', 'privateVar')
     *
     * @return mixed Value
     */
    function reflect() {
        $return = array();
        $class = new \ReflectionClass($this->testingClass);
        $return []= $class;

        if (func_num_args() > 0) {
            $args = func_get_args();

            foreach ($args as $name) {
                if (Text::beginsWith($name, 'method:')) {
                    $property = $class->getMethod(Text::getSubstringAfter($name, 'method:'));
                }
                else {
                    $property = $class->getProperty($name);
                }
                $property->setAccessible(true);
                $return []= $property;
            }
        }
        if (count($return) === 1) {
            return $class;
        }
        return $return;
    }

    /**
     * Helper function to call a function with arguments and return the result of the
     * function call and any echo'ed content.
     * @return array Array of the result of calling the function and any echo'ed content
     */
    function returnResultAndContent() {
        $function = func_get_arg(0);
        ob_start();
        if (func_num_args() > 1)
            $result = call_user_func_array($function, array_slice(func_get_args(), 1));
        else
            $result = call_user_func($function);
        $content = ob_get_clean();
        return array($result, $content);
    }

    /**
     * Helper function to echo content wrapped in a div with visibility that can be toggled.
     * @param string Content to echo
     */
    function echoContent($content) {
        if (method_exists($this->reporter, 'paintHTML')) {
            $this->reporter->paintHTML("<div class='rn_Hidden rn_verboseContent'>$content</div>");
        }
        else {
            $this->dump($content);
        }
    }

    /**
     * Alias to RightNow\UnitTest\Helpers::makeRequest
     * so that it can be called without the verbosity and ugliness
     * of namespaces and statics.
     */
    function makeRequest($url, $options = array(), $verbose = false) {
        return Helper::makeRequest($url, $options, $verbose);
    }

    /**
     * Alias to RightNow\UnitTest\Helpers::postArrayToParams
     */
    function postArrayToParams($post) {
        return Helper::postArrayToParams($post);
    }

    /**
     * Logs in as a contact.
     * @param string $userName name of user; defaults to slatest
     * if omitted
     * @param array $profileProperties Any properties to assign onto the logged-in profile
     * @return  object \ReflectionProperty session's profileData property
     */
    function logIn($userName = 'slatest', array $profileProperties = array()) {
        $session = new \ReflectionClass('RightNow\Libraries\Session');
        $profileData = new \ReflectionProperty('RightNow\Libraries\Session', 'profileData');
        $profileData->setAccessible(true);

        $profile = $this->CI->model('Contact')->getProfileSid($userName, '', $this->CI->session->getSessionData('sessionID'))->result ?: (object) array();
        foreach ($profileProperties as $name => $val) {
            $profile->{$name} = $val;
        }
        $profileData->setValue($this->CI->session, $profile);

        return $profileData;
    }

    /**
     * Logs out the current contact.
     * @return  object \ReflectionProperty session's profileData property
     */
    function logOut() {
        $profileData = new \ReflectionProperty('RightNow\Libraries\Session', 'profileData');
        $profileData->setAccessible(true);

        if($this->CI && $this->CI->session) {
            if ($authToken = $this->CI->session->getProfileData('authToken')){
                \RightNow\Api::contact_logout(array(
                    'cookie'    => $authToken,
                    'sessionid' => $this->CI->session->getSessionData('sessionID')
                ));
            }
            $profileData->setValue($this->CI->session, null);
        }

        return $profileData;
    }

    /**
     * Inject a URL parameter into the CodeIgniter framework that can be read by Url::getParameter()
     * Note: This function should be used in conjunction with restoreUrlParameters to reset the data once a test is complete
     * @param array $parameters An array of key/value pairs to set parameters (e.g. array('kw' => 'test'))
     */
    function addUrlParameters(array $parameters) {
        $this->CI = $this->CI ?: get_instance();
        $this->parameterSegment = $this->CI->config->item('parm_segment');
        $this->routerSegments = $segments = $this->CI->uri->router->segments;
        $firstKey = null;
        foreach($parameters as $key => $value) {
            $firstKey = $firstKey ?: $key;
            $segments[] = $key;
            $segments[] = $value;
        }
        $this->CI->uri->router->segments = $segments;
        if (!\RightNow\Utils\Url::getParameter($firstKey)) {
            $this->CI->config->set_item('parm_segment', $this->parameterSegment - 1);
        }
    }

    /**
     * Reset the original URL parameters stashed during the call to addUrlParameter
     */
    function restoreUrlParameters() {
        $this->CI->config->set_item('parm_segment', $this->parameterSegment);
        $this->CI->uri->router->segments = $this->routerSegments;
    }

    /**
     * Sets the session to avoid writing out cookies and invoking
     * previously sent header errors.
     */
    function setMockSession() {
        if (!class_exists('\RightNow\Libraries\MockSession')) {
            Mock::generate('\RightNow\Libraries\Session');
        }
        $session = new \RightNow\Libraries\MockSession;
        $this->realSession = $this->CI->session;
        $this->CI->session = $session;
        $session->setSessionData(array('sessionID' => 'garbage'));
    }

    /**
     * Restores the real session
     */
    function unsetMockSession() {
        if ($this->realSession) {
            $this->CI->session = $this->realSession;
            $this->realSession = null;
        }
    }

    /**
     * Subscribes a set of test functions as hook handler functions. Note that this is an additive
     * function and existing hooks will still remain.
     * @param array $hookInfo Array of arrays with keys 'name' and 'function'
     */
    function setHooks(array $hookInfo) {
        $hooks = Helper::getHooks();
        $hooksToSet = $hooks->getValue() ?: array();
        foreach ($hookInfo as $currentHook) {
            $hooksToSet[$currentHook['name']] = $hooksToSet[$currentHook['name']] ?: array();
            $hooksToSet[$currentHook['name']][] = array(
                'class' => isset($currentHook['class']) ? $currentHook['class'] : $this->hookEndpointClass,
                'function' => $currentHook['function'],
                'filepath' => isset($currentHook['filepath']) ? $currentHook['filepath'] : Text::getSubstringAfter($this->hookEndpointFilePath, SOURCEPATH, $this->hookEndpointFilePath),
                'use_standard_model' => isset($currentHook['use_standard_model']) ? $currentHook['use_standard_model'] : false,
            );
        }
        $hooks->setValue($hooksToSet);
    }

    /**
     * Subscribes a test function as a hook handler function
     * @param string $hookName name of hook
     * @param array $data data to be sent into the hook
     * @param string $function name of the handler function. defaults
     * to generic hookEndpoint function
     * @param boolean $callHook determines whether hook should be set
     * and fired or just set. defaults to true.
     */
    function setHook($hookName, array $data = array(), $function = 'hookEndpoint', $callHook = true) {
        $hooks = Helper::getHooks();
        $hooks->setValue(array($hookName => array(array(
            'class' => $this->hookEndpointClass,
            'function' => $function,
            'filepath' => Text::getSubstringAfter($this->hookEndpointFilePath, SOURCEPATH, $this->hookEndpointFilePath)
        ))));
        if ($callHook) {
            \RightNow\Libraries\Hooks::callHook($hookName, $data);
        }
    }

    /**
     * Sets the 'isInAbuse' cookie for testing.
     * @param String $isAbuse Usually 'true' or 'false'
     */
    function setIsAbuse($isAbuse = 'true') {
        $_COOKIE['isInAbuse'] = $isAbuse;
    }

    /**
     * Clears the 'isInAbuse' cookie
     */
    function clearIsAbuse() {
        unset($_COOKIE['isInAbuse']);
    }

    /**
     * Generic hook endpoint.
     * @param object $data data to set the member variable to
     */
    static function hookEndpoint($data) {
        self::$hookData = $data;
    }

    /**
     * Generic hook error
     * @return string hook error message
     */
    static function hookError() {
        return self::$hookErrorMsg;
    }

    /**
     * Writes contents to a file.
     * @param  string $fileName Name of file
     * @param  string $data     Data to write
     */
    function writeTempFile($fileName, $data) {
        umask(0);
        FileSystem::filePutContentsOrThrowExceptionOnFailure($this->getTestDir() . "/{$fileName}", $data);
    }

    /**
     * Creates a test dir.
     */
    function writeTempDir() {
        umask(0);
        FileSystem::mkdirOrThrowExceptionOnFailure($this->getTestDir(), true);
    }

    /**
     * Erases the temp dir housing any
     * files as used as part of the test.
     */
    function eraseTempDir() {
        FileSystem::removeDirectory($this->getTestDir(), true);
        $this->testDir = null;
    }

    /**
     * Returns the test dir.
     * @return string file path to test dir
     */
    protected function getTestDir() {
        $this->testDir || ($this->testDir = sprintf("%s/unitTest/%s/", get_cfg_var('upload_tmp_dir'), get_class($this)));

        return $this->testDir;
    }

    /**
     * You basically only want to call this in order to
     * stifle PHP's previously-sent-headers warning.
     */
    protected function downgradeErrorReporting() {
        error_reporting(~(E_NOTICE | E_WARNING));
    }

    /**
     * Sets back to default reporting level, everything
     * but notices.
     */
    protected function restoreErrorReporting() {
        error_reporting(~E_NOTICE);
    }
}
