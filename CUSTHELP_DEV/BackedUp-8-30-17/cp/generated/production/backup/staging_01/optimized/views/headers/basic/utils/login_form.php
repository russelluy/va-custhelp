<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/basic', 1 => '/euf/assets/themes/basic', 2 => array ( '/euf/assets/themes/basic' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/basic', ), ));
get_instance()->_checkMeta(array('javascript_module'=>'none', 'title'=>'' . \RightNow\Utils\Config::msgGetFrom((4833)) . '', 'template'=>'basic.php', 'redirect_if_logged_in'=>'account/overview', 'force_https'=>'true'));
get_instance()->clientLoader->setJavaScriptModule(get_instance()->meta['javascript_module']);
}
namespace Custom\Libraries\Widgets {
class CustomSharedViewPartials extends \RightNow\Libraries\Widgets\SharedViewPartials {
static function sample_view ($data) {
extract($data);
?>sample custom shared view partial<? }
}
}
namespace RightNow\Widgets{
class LoginForm extends \RightNow\Libraries\Widget\Base {
function _standard_login_LoginForm_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <div id="rn_<?=$this->instanceID;?>_Content">
        <div id="rn_<?=$this->instanceID;?>_ErrorMessage"></div>
        <form id="rn_<?=$this->instanceID;?>_Form" onsubmit="return false;">
            <label for="rn_<?=$this->instanceID;?>_Username"><?=$this->data['attrs']['label_username'];?></label>
            <input id="rn_<?=$this->instanceID;?>_Username" type="text" maxlength="80" name="Contact.Login" autocorrect="off" autocapitalize="off" value="<?=$this->data['username'];?>"/>
        <?
if(!$this->data['attrs']['disable_password']):?>
            <label for="rn_<?=$this->instanceID;?>_Password"><?=$this->data['attrs']['label_password'];?></label>
            <input id="rn_<?=$this->instanceID;?>_Password" type="password" maxlength="20" name="Contact.Password" <?=($this->data['attrs']['disable_password_autocomplete'])
? 'autocomplete="off"' : '' ?>>
        <? elseif($this->data['isIE']):?>
            <label for="rn_<?=$this->instanceID;?>_HiddenInput" class="rn_Hidden">&nbsp;</label>
            <input id="rn_<?=$this->instanceID;?>_HiddenInput" type="text" class="rn_Hidden" disabled="disabled" />
        <?
endif;?>
            <br/>
            <input id="rn_<?=$this->instanceID;?>_Submit" type="submit" value="<?=$this->data['attrs']['label_login_button'];?>"/>
            <br/>
        </form>
    </div>
</div><?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if(\RightNow\Utils\Framework::isLoggedIn()) return false;
\RightNow\Utils\Url::redirectIfPageNeedsToBeSecure();
$this->data['js']['f_tok'] = \RightNow\Utils\Framework::createTokenWithExpiration(0);
if(\RightNow\Utils\Url::getParameter('redirect')) {
$redirectLocation = urldecode(urldecode(\RightNow\Utils\Url::getParameter('redirect')));
$parsedURL = parse_url($redirectLocation);
if($parsedURL['scheme'] || (\RightNow\Utils\Text::beginsWith($parsedURL['path'], '/ci/') || \RightNow\Utils\Text::beginsWith($parsedURL['path'], '/cc/'))) {
$this->data['js']['redirectOverride'] = $redirectLocation;
}
else {
$this->data['js']['redirectOverride'] = \RightNow\Utils\Text::beginsWith($redirectLocation, '/app/') ? $redirectLocation : "/app/$redirectLocation";
}
}
$this->data['attrs']['disable_password'] = $this->data['attrs']['disable_password'] ?: !\RightNow\Utils\Config::getConfig((193));
$this->data['username'] = \RightNow\Utils\Url::getParameter('username');
if($this->CI->agent->browser() === 'Internet Explorer') $this->data['isIE'] = true;
}
}
function _standard_login_LoginForm_header() {
$result = array( 'js_name' => 'RightNow.Widgets.LoginForm', 'library_name' => 'LoginForm', 'view_func_name' => '_standard_login_LoginForm_view', 'meta' => array ( 'controller_path' => 'standard/login/LoginForm', 'view_path' => 'standard/login/LoginForm', 'js_path' => 'standard/login/LoginForm', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/LoginForm.css', 1 => 'assets/themes/standard/widgetCss/LoginForm.css', ), 'base_css' => array ( 0 => 'standard/login/LoginForm/base.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', 3 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4291)', 'urlParameters' => array ( 'redirect' => array ( 'name' => 'rn:msg:(3354)', 'description' => 'rn:msg:(1761)', 'example' => 'redirect/home', ), 'username' => array ( 'name' => 'rn:msg:(4846)', 'description' => 'rn:msg:(3199)', 'example' => 'username/JohnDoe', ), ), ), 'relativePath' => 'standard/login/LoginForm', 'widget_name' => 'LoginForm', ), );
$result['meta']['attributes'] = array( 'label_username' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4846), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4846), 'inherited' => false, )), 'label_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40564), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(40564), 'inherited' => false, )), 'label_login_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2601), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2601), 'inherited' => false, )), 'redirect_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'append_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'disable_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'login_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/doLogin', 'type' => 'AJAX', 'default' => '/ci/ajaxRequest/doLogin', 'inherited' => false, )), 'disable_password_autocomplete' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils;
class BasicLoginForm extends \RightNow\Widgets\LoginForm {
function _standard_login_BasicLoginForm_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <div id="rn_<?=$this->instanceID;?>_Content">
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/BasicFormStatusDisplay',
array());
?>
        <form method='post' action='<?= $this->data['attrs']['form_action'] ?>'><div>
            <label for="rn_<?=$this->instanceID;?>_Username"><?=$this->data['attrs']['label_username'];?></label>
            <input id="rn_<?=$this->instanceID;?>_Username" type="text" maxlength="80" name="Contact.Login" value="<?=$this->data['username'];?>"/>
        <?
if(!$this->data['attrs']['disable_password']):?>
            <label for="rn_<?=$this->instanceID;?>_Password"><?=$this->data['attrs']['label_password'];?></label>
            <input id="rn_<?=$this->instanceID;?>_Password" type="password" maxlength="20" name="Contact.Password" />
        <?
endif;?>
            <br/>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/input/BasicFormSubmit',
array('label_button' => '' . $this->data['attrs']['label_login_button'] . '','on_success_url' => '' . $this->data['on_success_url'] . '','add_params_to_url' => '' . $this->data['attrs']['append_to_url'] . '',));
?>
        <?= \RightNow\Utils\Widgets::addServerConstraints('' . $this->data['attrs']['form_action'] . '', '' . $this->data['attrs']['login_endpoint'] . '');
?></div></form>
    </div>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if (parent::getData() === false) {
return false;
}
if($prefilledUsername = $this->CI->input->post('Contact_Login')){
$this->data['username'] = $prefilledUsername;
}
$this->data['on_success_url'] = $this->data['js']['redirectOverride'] ?: $this->data['attrs']['redirect_url'] ?: Utils\Text::getSubstringAfter(($_SERVER['HTTP_RNT_REFERRER'] ?: $_SERVER['HTTP_REFERER']), Utils\Config::getConfig((9))) ?: Utils\Url::getHomePage();
if(!Utils\Config::getConfig((238))){
Utils\Framework::setTemporaryLoginCookie();
}
}
}
function _standard_login_BasicLoginForm_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicLoginForm', 'view_func_name' => '_standard_login_BasicLoginForm_view', 'meta' => array ( 'controller_path' => 'standard/login/BasicLoginForm', 'view_path' => 'standard/login/BasicLoginForm', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/BasicLoginForm.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', 3 => '3.4', ), 'jsModule' => array ( 0 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(43067)', ), 'extends' => array ( 'widget' => 'standard/login/LoginForm', 'versions' => array ( 0 => '1.1', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'contains' => array ( 0 => array ( 'widget' => 'standard/input/BasicFormSubmit', 'versions' => array ( 0 => '1.0', ), ), 1 => array ( 'widget' => 'standard/input/BasicFormStatusDisplay', 'versions' => array ( 0 => '1.0', ), ), ), 'relativePath' => 'standard/login/BasicLoginForm', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/login/LoginForm', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/login/LoginForm', ), 'widget_name' => 'BasicLoginForm', 'extends_php' => array ( 0 => 'standard/login/LoginForm', ), 'parent' => 'standard/login/LoginForm', ), );
$result['meta']['attributes'] = array( 'form_action' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/utils/login_form', 'type' => 'STRING', 'default' => '/app/utils/login_form', 'inherited' => false, )), 'login_endpoint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'postRequest/doLogin', 'type' => 'STRING', 'default' => 'postRequest/doLogin', 'inherited' => false, )), 'label_username' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4846), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4846), 'inherited' => true, )), 'label_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40564), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(40564), 'inherited' => true, )), 'label_login_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2601), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2601), 'inherited' => true, )), 'redirect_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'append_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'disable_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => true, )), 'disable_password_autocomplete' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
require_once CPCORE . 'Libraries/PostRequest.php';
class BasicFormStatusDisplay extends \RightNow\Libraries\Widget\Base {
function _standard_input_BasicFormStatusDisplay_view ($data) {
extract($data);
?><div class="rn_BasicFormStatusDisplay">
<? if($this->data['messages']): ?>
    <hr/><hr/>
    <? if($this->data['attrs']['label']): ?>
        <div><?=$this->data['attrs']['label']?></div>
    <? endif;
?>
    <? foreach($this->data['messages'] as $type => $types): ?>
        <? foreach($types as $field => $items): ?>
            <div class="rn_BasicFormStatusDisplay_<?=$type?>">
            <span class="rn_BasicFormStatusDisplay_Field"><?=$field;?></span>
            <?
foreach($items as $item): ?>
                <div><?=($field === '') ? $item : " - $item";?></div>
            <?
endforeach;
?>
            <br/></div>
        <? endforeach;
?>
    <? endforeach;
?>
    <hr/><hr/>
<? endif;
?>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['messages'] = \RightNow\Libraries\PostRequest::getMessages();
}
}
function _standard_input_BasicFormStatusDisplay_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicFormStatusDisplay', 'view_func_name' => '_standard_input_BasicFormStatusDisplay_view', 'meta' => array ( 'controller_path' => 'standard/input/BasicFormStatusDisplay', 'view_path' => 'standard/input/BasicFormStatusDisplay', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/BasicFormStatusDisplay.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', 3 => '3.4', ), 'jsModule' => array ( 0 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(43035)', ), 'relativePath' => 'standard/input/BasicFormStatusDisplay', 'widget_name' => 'BasicFormStatusDisplay', ), );
$result['meta']['attributes'] = array( 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class BasicFormSubmit extends \RightNow\Libraries\Widget\Base {
function _standard_input_BasicFormSubmit_view ($data) {
extract($data);
?><div class="<?= $this->classList ?>">
        <input type="submit" id="rn_<?= $this->instanceID ?>_Button" value="<?= $this->data['attrs']['label_button'] ?>"/>
    <input type="hidden" name="f_tok" value="<?=$this->data['f_tok']?>"/>
    <? foreach($this->data['format'] as $key => $value): ?>
        <? if($value): ?>
            <input type="hidden" name="format[<?=$key?>]" value="<?=$value?>"/>
        <? endif;
?>
    <? endforeach;
?>
</div><? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$this->data['f_tok'] = \RightNow\Utils\Framework::createTokenWithExpiration(0);
$this->data['format'] = array( 'on_success_url' => $this->data['attrs']['on_success_url'], 'add_params_to_url' => $this->data['attrs']['add_params_to_url'], );
}
}
function _standard_input_BasicFormSubmit_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicFormSubmit', 'view_func_name' => '_standard_input_BasicFormSubmit_view', 'meta' => array ( 'controller_path' => 'standard/input/BasicFormSubmit', 'view_path' => 'standard/input/BasicFormSubmit', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', 3 => '3.4', ), 'jsModule' => array ( 0 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(43036)', ), 'relativePath' => 'standard/input/BasicFormSubmit', 'widget_name' => 'BasicFormSubmit', ), );
$result['meta']['attributes'] = array( 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4550), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4550), 'inherited' => false, )), 'on_success_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'add_params_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class ClickjackPrevention extends \RightNow\Libraries\Widget\Base {
function _standard_utils_ClickjackPrevention_view ($data) {
extract($data);
?><? if ($this->data['attrs']['frame_options'] === "DENY"): ?>
    <script type="text/javascript">
    <!--
    if (parent !== self) {
        top.location.href = location.href;
    }
    else if (top !== self) {
        top.location.href = self.document.location;
    }
    //-->
    </script>
<? endif;
?>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
header("X-Frame-Options: " . $this->data['attrs']['frame_options']);
}
}
function _standard_utils_ClickjackPrevention_header() {
$result = array( 'js_name' => '', 'library_name' => 'ClickjackPrevention', 'view_func_name' => '_standard_utils_ClickjackPrevention_view', 'meta' => array ( 'controller_path' => 'standard/utils/ClickjackPrevention', 'view_path' => 'standard/utils/ClickjackPrevention', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', 3 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(45063)', ), 'relativePath' => 'standard/utils/ClickjackPrevention', 'widget_name' => 'ClickjackPrevention', ), );
$result['meta']['attributes'] = array( 'frame_options' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'DENY', 'type' => 'OPTION', 'default' => 'DENY', 'options' => array(0 => 'DENY', 1 => 'SAMEORIGIN', ), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Text, RightNow\Utils\Url;
class CapabilityDetector extends \RightNow\Libraries\Widget\Base {
function _standard_utils_CapabilityDetector_view ($data) {
extract($data);
?><div class="<?=$this->classList?>" id="rn_<?=$this->instanceID?>">
    <? if($this->data['label_tests_fail']): ?>
    <noscript>
        <div class="MessageContainer MessageContainerFailure">
            <?= $this->data['label_tests_fail'] ?>
        </div>
    </noscript>
    <? endif;
?>
    <div id="rn_<?=$this->instanceID?>_MessageContainer">
    </div>
    <? ?>
    <?='<' . 'script type="text/javascript"><!' . "-- \n /*<![" . 'CDATA[*/'?>
(function () {
    var runJSTests = function() {
        var messageContainerDiv = document.getElementById('rn_<?= $this->instanceID ?>_MessageContainer');
        function showFailure() {
            <? if($this->data['label_tests_fail']): ?>
            messageContainerDiv.className = 'MessageContainer MessageContainerFailure';
            messageContainerDiv.innerHTML = '<?= str_replace("'", "\'", $this->data['label_tests_fail']) ?>';
            <? endif;
?>
            <? if($this->data['automatically_redirect']): ?>
            window.location = '<?= $this->data['link_tests_fail'] ?>';
            <? endif;
?>
        }
        <? if($this->data['runJSTests']): ?>
        <? if($this->data['attrs']['display_if_no_xhr_object']): ?>
        function xhrTestFails() {
            return !window.XMLHttpRequest;
        }
        if(typeof RightNowTesting !== 'undefined' && RightNowTesting._isTesting) {
            RightNowTesting._xhrTestFails = xhrTestFails;
        }
        if (xhrTestFails()) {
            showFailure();
            return;
        }
        <? endif;
?>
        <? endif;
?>
        <? if($this->data['showSuccessMessage']): ?>
        messageContainerDiv.className = 'MessageContainer MessageContainerSuccess';
        messageContainerDiv.innerHTML = '<?= str_replace("'", "\'", $this->data['label_tests_pass']) ?>';
        <? endif;
?>
    }
    if(typeof RightNowTesting !== 'undefined' && RightNowTesting._isTesting) {
        RightNowTesting._runJSTests = runJSTests;
    }
    runJSTests();
})();
    <?='/*]' . ']>*/ // --></' . 'script>'?>
</div>
<? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if($this->data['attrs']['fail_page_set'] === $this->data['attrs']['pass_page_set']) {
echo $this->reportError(\RightNow\Utils\Config::getMessage((43090)));
return false;
}
$currentPageSetPath = $this->CI->getPageSetPath() ?: 'default';
$automaticallyRedirect = $this->data['attrs']['automatically_redirect_on_failure'];
$pageSetInvalid = false;
$this->data['runJSTests'] = true;
$this->data['showSuccessMessage'] = $this->data['attrs']['display_tests_pass'];
$this->data['link_tests_fail'] = '/ci/redirect/pageSet/' . urlencode($this->data['attrs']['fail_page_set']) . '/' . Url::deleteParameter(Text::getSubstringAfter($_SERVER['REQUEST_URI'], "/app/"), 'session') . Url::sessionParameter();
$this->data['label_tests_fail'] = sprintf($this->data['attrs']['label_tests_fail'], $this->data['link_tests_fail']);
$this->data['label_tests_pass'] = sprintf($this->data['attrs']['label_tests_pass'], '/ci/redirect/pageSet/' . urlencode($this->data['attrs']['pass_page_set']) . '/' . Url::deleteParameter(Text::getSubstringAfter($_SERVER['REQUEST_URI'], "/app/"), 'session') . Url::sessionParameter());
$enabledPageSetMappings = $this->CI->model('Pageset')->getEnabledPageSetMappingArrays();
if($currentPageSetPath === $this->data['attrs']['fail_page_set']) {
$automaticallyRedirect = false;
$this->data['link_tests_fail'] = '';
$this->data['label_tests_fail'] = '';
}
else if($currentPageSetPath === $this->data['attrs']['pass_page_set']) {
$this->data['showSuccessMessage'] = false;
}
if($this->data['attrs']['fail_page_set'] !== 'default' && !isset($enabledPageSetMappings[$this->data['attrs']['fail_page_set']])) {
$automaticallyRedirect = false;
$this->data['link_tests_fail'] = '';
$this->data['label_tests_fail'] = $this->data['attrs']['label_no_link'];
$this->data['runJSTests'] = $this->data['attrs']['perform_javascript_checks_with_no_link'];
}
if($this->data['attrs']['pass_page_set'] !== 'default' && !isset($enabledPageSetMappings[$this->data['attrs']['pass_page_set']])) {
$this->data['showSuccessMessage'] = false;
$this->data['label_tests_pass'] = '';
}
if(!$this->data['link_tests_fail'] && !$this->data['label_tests_pass']) {
echo $this->reportError(\RightNow\Utils\Config::getMessage((43091)));
return false;
}
$this->data['automatically_redirect'] = $automaticallyRedirect;
if($automaticallyRedirect) {
$this->CI->clientLoader->addHeadContent('<noscript><META http-equiv="refresh" content="0;URL=' . $this->data['link_tests_fail'] . '"></noscript>');
}
}
}
function _standard_utils_CapabilityDetector_header() {
$result = array( 'js_name' => '', 'library_name' => 'CapabilityDetector', 'view_func_name' => '_standard_utils_CapabilityDetector_view', 'meta' => array ( 'controller_path' => 'standard/utils/CapabilityDetector', 'view_path' => 'standard/utils/CapabilityDetector', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/CapabilityDetector.css', 1 => 'assets/themes/basic/widgetCss/CapabilityDetector.css', 2 => 'assets/themes/standard/widgetCss/CapabilityDetector.css', ), 'version' => '1.0.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', 3 => '3.4', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', 2 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(51877)', ), 'relativePath' => 'standard/utils/CapabilityDetector', 'widget_name' => 'CapabilityDetector', ), );
$result['meta']['attributes'] = array( 'automatically_redirect_on_failure' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'bool', 'default' => false, 'inherited' => false, )), 'display_if_no_xhr_object' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'bool', 'default' => true, 'inherited' => false, )), 'display_tests_pass' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'bool', 'default' => false, 'inherited' => false, )), 'label_tests_fail' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43112), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(43112), 'inherited' => false, )), 'label_no_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43111), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(43111), 'inherited' => false, )), 'label_tests_pass' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43113), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(43113), 'inherited' => false, )), 'fail_page_set' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'basic', 'type' => 'string', 'default' => 'basic', 'inherited' => false, )), 'pass_page_set' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'default', 'type' => 'string', 'default' => 'default', 'inherited' => false, )), 'perform_javascript_checks_with_no_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'bool', 'default' => true, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Framework, RightNow\Utils\Text, RightNow\Utils\Url;
class LogoutLink extends \RightNow\Libraries\Widget\Base {
function _standard_login_LogoutLink_view ($data) {
extract($data);
?><?php ?>
<span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <a id="rn_<?=$this->instanceID;?>_LogoutLink" href="javascript:void(0);"><?=$this->data['attrs']['label'];?></a>
</span>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
$this->setAjaxHandlers(array( 'logout_ajax' => array( 'method' => 'doLogout', 'clickstream' => 'account_logout', ), ));
}
function getData() {
if(!Framework::isLoggedIn() || (Framework::isPta() && !\RightNow\Utils\Config::getConfig((378)))) return false;
if(Framework::isPta()){
$this->data['js']['redirectLocation'] = Url::deleteParameter((\RightNow\Utils\Config::getConfig((25), 'COMMON') ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], 'sno');
}
else if($this->data['attrs']['redirect_url']){
$this->data['js']['redirectLocation'] = $this->data['attrs']['redirect_url'];
}
else{
$this->data['js']['redirectLocation'] = Url::deleteParameter($_SERVER['REQUEST_URI'], 'sno');
}
$this->data['js']['redirectLocation'] = Url::deleteParameter($this->data['js']['redirectLocation'], 'sno');
if(\RightNow\Utils\Url::sessionParameter() !== '') $this->data['js']['redirectLocation'] = Url::addParameter($this->data['js']['redirectLocation'], 'session', Text::getSubstringAfter(Url::sessionParameter(), "session/"));
if(\RightNow\Utils\Framework::isPta()){
$this->data['js']['redirectLocation'] = str_ireplace('%source_page%', urlencode($this->data['js']['redirectLocation']), \RightNow\Utils\Config::getConfig((378)));
}
if(\RightNow\Utils\Config::getConfig((701), 'RNW')){
if($socialLogoutUrl = \RightNow\Utils\Config::getConfig((703), 'RNW')){
$socialLogoutUrl .= '/scripts/signout';
$redirectComponents = parse_url($this->data['js']['redirectLocation']);
if($redirectComponents['host']){
$socialLogoutUrl .= '?redirectUrl=' . urlencode($this->data['js']['redirectLocation']);
}
else{
$socialLogoutUrl .= '?redirectUrl=' . urlencode(Url::getShortEufBaseUrl('sameAsCurrentPage', $this->data['js']['redirectLocation']));
}
$this->data['js']['redirectLocation'] = $socialLogoutUrl;
}
else{
echo $this->reportError(\RightNow\Utils\Config::getMessage((1294)));
return false;
}
}
}
function doLogout($parameters) {
Url::redirectToHttpsIfNecessary();
$result = $this->CI->model('Contact')->doLogout($parameters['url'], $parameters['redirectUrl'])->result;
echo json_encode($result);
}
}
function _standard_login_LogoutLink_header() {
$result = array( 'js_name' => 'RightNow.Widgets.LogoutLink', 'library_name' => 'LogoutLink', 'view_func_name' => '_standard_login_LogoutLink_view', 'meta' => array ( 'controller_path' => 'standard/login/LogoutLink', 'view_path' => 'standard/login/LogoutLink', 'js_path' => 'standard/login/LogoutLink', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4293)', ), 'relativePath' => 'standard/login/LogoutLink', 'widget_name' => 'LogoutLink', ), );
$result['meta']['attributes'] = array( 'logout_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajax/widget', 'type' => 'AJAX', 'default' => '/ci/ajax/widget', 'inherited' => false, )), 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(42023), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(42023), 'inherited' => false, )), 'redirect_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((226)), 'type' => 'STRING', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((226)), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class BasicLogoutLink extends \RightNow\Widgets\LogoutLink {
function _standard_login_BasicLogoutLink_view ($data) {
extract($data);
?><?php ?>
<span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <a id="rn_<?=$this->instanceID;?>_LogoutLink" href="/ci/openlogin/logout/<?=$this->data['redirectUrl'];?><?=\RightNow\Utils\Url::sessionParameter();?>"><?=$this->data['attrs']['label'];?></a>
</span>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if (parent::getData() === false) {
return false;
}
$this->data['redirectUrl'] = $redirectUrl = $this->data['js']['redirectLocation'];
if ($redirectUrl && \RightNow\Utils\Text::beginsWith($redirectUrl, '/')) {
$this->data['redirectUrl'] = substr($redirectUrl, 1);
}
}
}
function _standard_login_BasicLogoutLink_header() {
$result = array( 'js_name' => '', 'library_name' => 'BasicLogoutLink', 'view_func_name' => '_standard_login_BasicLogoutLink_view', 'meta' => array ( 'controller_path' => 'standard/login/BasicLogoutLink', 'view_path' => 'standard/login/BasicLogoutLink', 'presentation_css' => array ( 0 => 'assets/themes/basic/widgetCss/BasicLogoutLink.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'none', ), ), 'info' => array ( 'description' => 'rn:msg:(43068)', ), 'extends' => array ( 'widget' => 'standard/login/LogoutLink', 'versions' => array ( 0 => '1.0', ), 'components' => array ( 'php' => true, ), 'overrideViewAndLogic' => true, ), 'relativePath' => 'standard/login/BasicLogoutLink', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/login/LogoutLink', ), 'view' => array ( ), 'logic' => array ( ), 'js_templates' => array ( ), 'base_css' => array ( ), 'presentation_css' => array ( ), 'parent' => 'standard/login/LogoutLink', ), 'widget_name' => 'BasicLogoutLink', 'extends_php' => array ( 0 => 'standard/login/LogoutLink', ), 'parent' => 'standard/login/LogoutLink', ), );
$result['meta']['attributes'] = array( 'label' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(42023), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(42023), 'inherited' => true, )), 'redirect_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((226)), 'type' => 'STRING', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((226)), 'inherited' => true, )), );
return $result;
}
}
namespace RightNow\Widgets{
class PageSetSelector extends \RightNow\Libraries\Widget\Base {
function _standard_utils_PageSetSelector_view ($data) {
extract($data);
?><?php ?>
<span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <?=$this->data['attrs']['label_message'];?>
    <?
foreach($this->data['sets'] as $key => $set):?>
        <? if($set['current']):?>
            <span class="rn_Bold"><?=$set['label'];?></span>
        <?
else:?>
            <a href="/ci/redirect/pageSet/<?=urlencode($set['mapping'])?>/<?=htmlspecialchars($this->data['currentPage'], ENT_QUOTES, 'UTF-8')?><?=\RightNow\Utils\Url::sessionParameter();?>"><?=$set['label'];?></a>
        <?
endif;?>
        <?=((++$count
< count($this->data['sets'])) ? '|' : '');?>
    <?
endforeach;?>
</span>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if(!\RightNow\Utils\Config::getConfig((238))) {
echo $this->reportError(\RightNow\Utils\Config::getMessage((1406)));
return false;
}
$this->data['sets'] = array('/' => array());
$sets = explode(',', trim($this->data['attrs']['page_sets']));
if(!count(array_filter($sets))) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((2997)), 'page_sets'));
return false;
}
$enabledPageSetMappings = $this->CI->model('Pageset')->getEnabledPageSetMappingArrays();
foreach($sets as $set) {
list($pageSet, $label) = array_map('trim', explode('>', $set));
if ($pageSet === "default" || isset($enabledPageSetMappings[$pageSet])) {
$this->data['sets'][$pageSet]['label'] = $label;
$this->data['sets'][$pageSet]['mapping'] = $pageSet;
}
}
$cookie = $_COOKIE['agent'];
if(!$cookie) {
$currentPageSet = $this->CI->getPageSetPath();
$cookie = $currentPageSet ? $currentPageSet : '/';
}
if($cookie) {
if($this->data['sets']['default']) {
$this->data['sets']['/'] = $this->data['sets']['default'];
unset($this->data['sets']['default']);
if($cookie === '/') $this->data['sets']['/']['current'] = true;
}
if($this->data['sets'][$cookie]) {
$this->data['sets'][$cookie]['current'] = true;
}
if($this->data['attrs']['cookie_expiration']) {
$this->data['expires'] = date(DATE_COOKIE, time() + ($this->data['attrs']['cookie_expiration'] * 86400));
}
$this->data['secure'] = \RightNow\Utils\Config::getConfig((25), 'COMMON') ? 'secure' : '';
}
if (count($this->data['sets']) <= 1) {
$this->classList->add('rn_Hidden');
$this->classList->remove('rn_PageSetSelector');
}
$this->data['currentPage'] = \RightNow\Utils\Text::getSubstringAfter(ORIGINAL_REQUEST_URI, "/app/");
}
}
function _standard_utils_PageSetSelector_header() {
$result = array( 'js_name' => '', 'library_name' => 'PageSetSelector', 'view_func_name' => '_standard_utils_PageSetSelector_view', 'meta' => array ( 'controller_path' => 'standard/utils/PageSetSelector', 'view_path' => 'standard/utils/PageSetSelector', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/PageSetSelector.css', 1 => 'assets/themes/basic/widgetCss/PageSetSelector.css', 2 => 'assets/themes/standard/widgetCss/PageSetSelector.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', ), 'jsModule' => array ( 0 => 'none', 1 => 'standard', 2 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4224)', ), 'relativePath' => 'standard/utils/PageSetSelector', 'widget_name' => 'PageSetSelector', ), );
$result['meta']['attributes'] = array( 'cookie_expiration' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 10, 'type' => 'INT', 'default' => 10, 'inherited' => false, )), 'label_message' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4157), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4157), 'inherited' => false, )), 'page_sets' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => sprintf('default > %s, mobile > %s, basic > %s', \RightNow\Utils\Config::getMessage((1572)), \RightNow\Utils\Config::getMessage((4880)), \RightNow\Utils\Config::getMessage((43115))), 'type' => 'STRING', 'default' => sprintf('default > %s, mobile > %s, basic > %s', \RightNow\Utils\Config::getMessage((1572)), \RightNow\Utils\Config::getMessage((4880)), \RightNow\Utils\Config::getMessage((43115))), 'inherited' => false, )), );
return $result;
}
}
namespace{
use \RightNow\Utils\FileSystem;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN" "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
<html lang="<?=\RightNow\Utils\Text::getLanguageCode();?>">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <title><?=\RightNow\Utils\Tags::getPageTitleAtRuntime();?></title>
        <style type="text/css">
            <!--
            #rn_SkipNav a{
                left:0px;
                height:1px;
                overflow:hidden;
                position:absolute;
                top:-500px;
                width:1px;
            }
            #rn_SkipNav a:active, #rn_SkipNav a:focus{
                background-color:#FFF;
                height:auto;
                left:auto;
                top:auto;
                width:auto;
            }
            .rn_Header{
                font-weight:bold;
                font-size:18pt;
            }
            .rn_LinksBlock a{
                display:block;
                margin-bottom:10px;
            }
            a img{
                border:0;
            }
            .rn_CenterText{
                text-align:center;
            }
            h1{
                font-weight:bold;
                font-size:16pt;
                line-height:1.4em;
                margin:0;
                padding:0;
            }
            h2{
                font-size:14pt;
                line-height:1.3em;
                margin:0;
                padding:0;
            }
            h3{
                font-size:12pt;
                line-height:1.2em;
                margin:0;
                padding:0;
            }
            -->
        </style>
        <?=
\RightNow\Libraries\SEO::getCanonicalLinkTag() . "\n";
?>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<style type='text/css'>
 <!-- 
.rn_ScreenReaderOnly{position:absolute; height:1px; left:-10000px; overflow:hidden; top:auto; width:1px;}
.rn_Hidden{display:none;}
 --></style>
<base href='<?=\RightNow\Utils\Url::getShortEufBaseUrl('sameAsRequest', \RightNow\Utils\FileSystem::getOptimizedAssetsDir() . 'themes/basic/');?>'></base>
<style type="text/css">
<!--
.rn_CapabilityDetector .MessageContainer{font-size: 1.5em;line-height: 1em;padding: 10px;text-align: center;border-style: solid;border-width: 2px;}
.rn_BasicLogoutLink{display:inline-block;}
.rn_PageSetSelector{margin: 10px 0;display: block;}
.rn_BasicLoginForm label{display:block;}
.rn_BasicLoginForm input[type="text"], .rn_BasicLoginForm input[type="password"]{width: 63%;max-width: 250px;}
.rn_BasicLoginForm input{margin-bottom: 4px;}
.rn_BasicFormStatusDisplay{font-weight:bold;}
.rn_BasicFormStatusDisplay_error{color:#E80000;}
.rn_BasicFormStatusDisplay_info{color:#008000;}
.rn_BasicFormStatusDisplay_Field{font-size:1.2em;}
-->
</style>
9c1379bc-cca6-4750-aee7-188f8348a6c3
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/utils/ClickjackPrevention',
array());
?>
    </head>
    <body>
        <div id="rn_SkipNav"><a href="<?=ORIGINAL_REQUEST_URI?>#rn_MainContent"><?=\RightNow\Utils\Config::msgGetFrom((3673));?></a></div>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/utils/CapabilityDetector',
array());
?>
        <div class="rn_Header rn_CenterText"><?=\RightNow\Utils\Config::msgGetFrom((43198));?></div>
        <hr/>
        <div class="rn_CenterText">
            <a href="/app/<?=\RightNow\Utils\Config::configGetFrom((226));?><?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2097));?></a>&nbsp;|
            <a href="/app/ask<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((1748));?></a>&nbsp;|
            <a href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((43191));?></a>
        </div>
        <hr/>
        <div><a id="rn_MainContent"></a></div>
<?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/BasicLoginForm',
array());
?>
<p>
    <a href="/app/<?=\RightNow\Utils\Config::configGetFrom((220));?><?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2013));?></a>
</p>
        <hr/>
        <div class="rn_CenterText">
            <?if(
(\RightNow\Utils\Framework::isLoggedIn()) ):?>
                <strong><?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array ( 0 => 'Contact', 1 => 'LookupName', ), false);?><?if(
(in_array(strtolower(\RightNow\Utils\Text::getLanguageCode()), array("ja-jp"))) ):?><?=\RightNow\Utils\Config::msgGetFrom((7023));?><?endif;?></strong>&nbsp;|
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/BasicLogoutLink',
array('label' => '' . \RightNow\Utils\Config::msgGetFrom((5280)) . '',));
?>&nbsp;|
                <a href="/app/account/overview<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((4436));?></a>
            <?else:?>
                <?if(
(\RightNow\Utils\Config::getConfig(372) == true) ):?>
                    <a href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((2601));?></a>&nbsp;|
                    <a href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((3650));?></a>
                <?else:?>
                    <a href="/app/<?=\RightNow\Utils\Config::configGetFrom((229));?><?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2601));?></a>&nbsp;|
                    <a href="/app/utils/create_account<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((3650));?></a>
                <?endif;?>
            <?endif;?>
            <br/>
            <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/utils/PageSetSelector',
array('label_message' => '',));
?>
        </div>
<?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
