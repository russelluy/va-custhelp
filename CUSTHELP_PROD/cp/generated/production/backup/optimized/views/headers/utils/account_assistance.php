<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/standard', 1 => '/euf/assets/themes/standard', 2 => array ( '/euf/assets/themes/standard' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/standard', ), ));
get_instance()->_checkMeta(array('title'=>'' . \RightNow\Utils\Config::msgGetFrom((901)) . '', 'template'=>'standard.php', 'login_required'=>'false'));
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
class EmailCredentials extends \RightNow\Libraries\Widget\Base {
function _standard_login_EmailCredentials_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <?if($this->data['attrs']['label_heading'] !== ''):?>
        <h2><?=$this->data['attrs']['label_heading']?></h2>
    <?endif;?>
    <?if($this->data['attrs']['label_description']
!== ''):?>
        <p><?=$this->data['attrs']['label_description']?></p>
    <?endif;?>
    <?
$selectorPrefix = "rn_{$this->instanceID}_{$this->data['attrs']['credential_type']}";
?>
    <form id="<?=$selectorPrefix;?>_Form" onsubmit="return false;">
        <label for="<?=$selectorPrefix;?>_Input"><?=$this->data['attrs']['label_input'];?></label>
        <input id="<?=$selectorPrefix;?>_Input" name="<?=$this->data['js']['request_type'];?>" type="text" maxlength="80" autocorrect="off" autocapitalize="off" value="<?=$this->data['email'];?>" />
        <input id="<?=$selectorPrefix;?>_Submit" type="submit" value="<?=$this->data['attrs']['label_button']?>" />
        <div id="<?=$selectorPrefix;?>_LoadingIcon"></div>
    </form>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
$this->setAjaxHandlers(array( 'email_credentials_ajax' => array( 'method' => 'sendEmailCredentials', 'clickstream' => 'emailCredentials', 'exempt_from_login_requirement' => true, ), ));
}
function getData() {
$credentialType = $this->data['attrs']['credential_type'];
$this->data['js']['request_type'] = 'email' . ucfirst($credentialType);
if ($credentialType === 'password') {
if (!\RightNow\Utils\Config::getConfig((193))) return false;
$this->data['js']['field_required'] = \RightNow\Utils\Config::getMessage((1046));
}
else {
$this->data['js']['field_required'] = \RightNow\Utils\Config::getMessage((977));
if ($previouslySeenEmail = $this->CI->session->getSessionData('previouslySeenEmail')) {
$this->data['email'] = $previouslySeenEmail;
}
else if ($urlParm = \RightNow\Utils\Url::getParameter('Contact.Emails.PRIMARY.Address')) {
$this->data['email'] = $urlParm;
}
}
}
function sendEmailCredentials($parameters) {
\RightNow\Libraries\AbuseDetection::check();
$method = ($this->data['attrs']['credential_type'] === 'password') ? 'sendResetPasswordEmail' : 'sendLoginEmail';
echo json_encode($this->CI->model('Contact')->$method($parameters['value'])->result);
}
}
function _standard_login_EmailCredentials_header() {
$result = array( 'js_name' => 'RightNow.Widgets.EmailCredentials', 'library_name' => 'EmailCredentials', 'view_func_name' => '_standard_login_EmailCredentials_view', 'meta' => array ( 'controller_path' => 'standard/login/EmailCredentials', 'view_path' => 'standard/login/EmailCredentials', 'js_path' => 'standard/login/EmailCredentials', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/EmailCredentials.css', 1 => 'assets/themes/standard/widgetCss/EmailCredentials.css', ), 'version' => '1.2.1', 'requires' => array ( 'framework' => array ( 0 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4327)', 'urlParameters' => array ( 'Contact.Emails.PRIMARY.Address' => array ( 'name' => 'rn:msg:(41568)', 'description' => 'rn:msg:(41628)', 'example' => 'Contact.Emails.PRIMARY.Address/test@example.com', ), ), ), 'relativePath' => 'standard/login/EmailCredentials', 'widget_name' => 'EmailCredentials', ), );
$result['meta']['attributes'] = array( 'email_credentials_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajax/widget', 'type' => 'ajax', 'default' => '/ci/ajax/widget', 'inherited' => false, )), 'credential_type' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'password', 'type' => 'option', 'default' => 'password', 'options' => array(0 => 'password', 1 => 'username', ), 'inherited' => false, )), 'label_heading' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3411), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3411), 'inherited' => false, )), 'label_description' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1734), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(1734), 'inherited' => false, )), 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3410), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(3410), 'inherited' => false, )), 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4846), 'type' => 'string', 'default' => \RightNow\Utils\Config::getMessage(4846), 'inherited' => false, )), 'initial_focus' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class BrowserSearchPlugin extends \RightNow\Libraries\Widget\Base {
function _standard_search_BrowserSearchPlugin_view ($data) {
extract($data);
?><link rel="search" type="application/opensearchdescription+xml" title="<?=$this->data['title']?>" href="/ci/browserSearch/desc/<?=$this->data['url'];?>/<?=$this->data['attrs']['title']?>/<?=$this->data['attrs']['description']?>/<?=$this->data['attrs']['icon_path']?>"/>
<?
}
function __construct($attrs){
parent::__construct($attrs);
}
function getData(){
if(!strlen($this->data['attrs']['pages'])) return false;
$this->data['attrs']['pages'] = explode(',', str_replace(' ', '', $this->data['attrs']['pages']));
$segmentUrl = '';
$pageSegments = $this->CI->config->item('parm_segment');
for($i = 3;
$i < $pageSegments;
$i++) $segmentUrl .= $this->CI->uri->segment($i) . '/';
$segmentUrl = substr($segmentUrl, 0, strlen($segmentUrl) - 1);
if(in_array($segmentUrl, $this->data['attrs']['pages'])) $this->constructOutput($segmentUrl);
else return false;
}
protected function constructOutput($page){
if(strlen($this->data['attrs']['search_page'])) $page = $this->data['attrs']['search_page'];
if(substr($page, -1) !== '/') $page .= '/';
if(substr($page, 0) !== '/') $page = '/' . $page;
$page .= 'kw/{searchTerms}';
$this->data['url'] = urlencode(\RightNow\Utils\Url::getShortEufAppUrl('sameAsCurrentPage', $page));
$this->data['title'] = $this->data['attrs']['title'];
$this->data['attrs']['title'] = urlencode($this->data['attrs']['title']);
$this->data['attrs']['description'] = urlencode($this->data['attrs']['description']);
$this->data['attrs']['icon_path'] = urlencode($this->data['attrs']['icon_path']);
}
}
function _standard_search_BrowserSearchPlugin_header() {
$result = array( 'js_name' => '', 'library_name' => 'BrowserSearchPlugin', 'view_func_name' => '_standard_search_BrowserSearchPlugin_view', 'meta' => array ( 'controller_path' => 'standard/search/BrowserSearchPlugin', 'view_path' => 'standard/search/BrowserSearchPlugin', 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4363)', ), 'relativePath' => 'standard/search/BrowserSearchPlugin', 'widget_name' => 'BrowserSearchPlugin', ), );
$result['meta']['attributes'] = array( 'pages' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'home, answers/list, answers/detail', 'type' => 'STRING', 'default' => 'home, answers/list, answers/detail', 'inherited' => false, )), 'search_page' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'answers/list', 'type' => 'STRING', 'default' => 'answers/list', 'inherited' => false, )), 'title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'inherited' => false, )), 'description' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage((4525)) . ' ' . \RightNow\Utils\Config::getMessage((4565)), 'inherited' => false, )), 'icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/euf/assets/images/icons/favicon_browserSearchPlugin.ico', 'type' => 'STRING', 'default' => '/euf/assets/images/icons/favicon_browserSearchPlugin.ico', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
use RightNow\Utils\Framework, RightNow\Utils\Text, RightNow\Utils\Url;
class LogoutLink extends \RightNow\Libraries\Widget\Base {
function _standard_login_LogoutLink_view ($data) {
extract($data);
?><span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
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
use RightNow\Utils\Text, RightNow\Utils\Url;
class LoginDialog extends \RightNow\Libraries\Widget\Base {
function _standard_login_LoginDialog_view ($data) {
extract($data);
?><div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?> rn_Hidden">
    <? if($this->data['attrs']['open_login_url']):?>
    <div class="rn_OpenLoginAlternative">
        <a id="rn_<?=$this->instanceID;?>_OpenLoginLink" href="<?=$this->data['attrs']['open_login_url'].
\RightNow\Utils\Url::sessionParameter();?>"><?=$this->data['attrs']['label_open_login_link'];?></a>
    </div>
    <?
endif;?>
    <div id="rn_<?=$this->instanceID;?>_Content" class="rn_LoginDialogContent">
        <div id="rn_<?=$this->instanceID;?>_ErrorMessage"></div>
        <form id="rn_<?=$this->instanceID;?>_Form" onsubmit="return false;">
            <label for="rn_<?=$this->instanceID;?>_Username"><?=$this->data['attrs']['label_username'];?></label>
            <input id="rn_<?=$this->instanceID;?>_Username" type="text" maxlength="80" name="Contact.Login" autocorrect="off" autocapitalize="off" value="<?=$this->data['username'];?>"/>
        <?
if(!$this->data['attrs']['disable_password']):?>
            <label for="rn_<?=$this->instanceID;?>_Password"><?=$this->data['attrs']['label_password'];?></label>
            <input id="rn_<?=$this->instanceID;?>_Password" type="password" name="Contact.Password" maxlength="20" <?=($this->data['attrs']['disable_password_autocomplete'])
? 'autocomplete="off"' : '' ?>>
        <? endif;?>
        </form>
        <span><a href="<?=$this->data['attrs']['assistance_url'].
\RightNow\Utils\Url::sessionParameter();?>"><?=$this->data['attrs']['label_assistance'];?></a></span>
    </div>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if(\RightNow\Utils\Framework::isLoggedIn()) return false;
if($redirectLocation = \RightNow\Utils\Url::getParameter('redirect')) {
$redirectLocation = urldecode(urldecode($redirectLocation));
$parsedURL = parse_url($redirectLocation);
if($parsedURL['scheme'] || (Text::beginsWith($parsedURL['path'], '/ci/') || Text::beginsWith($parsedURL['path'], '/cc/'))) {
$this->data['js']['redirectOverride'] = $redirectLocation;
}
else {
$this->data['js']['redirectOverride'] = Text::beginsWith($redirectLocation, '/app/') ? $redirectLocation : "/app/$redirectLocation";
}
}
$redirectPage = $this->data['js']['redirectOverride'] ?: ($this->data['attrs']['redirect_url'] ?: $_SERVER['REQUEST_URI']);
if(\RightNow\Utils\Config::getConfig((239)) && !Url::isRequestHttps()) {
$this->data['js']['loginLinkOverride'] = Url::addParameter(Url::getShortEufBaseUrl('sameAsRequest', '/app/' . \RightNow\Utils\Config::getConfig((229)) . Url::sessionParameter()), 'redirect', urlencode(urlencode($redirectPage)));
}
if($this->data['attrs']['open_login_url']) {
$this->classList->add('rn_AdditionalOpenLogin');
if (!Text::stringContains($this->data['attrs']['open_login_url'], '/redirect/')) {
$this->data['attrs']['open_login_url'] = Url::addParameter($this->data['attrs']['open_login_url'], 'redirect', urlencode(urlencode($redirectPage)));
}
}
$this->data['attrs']['disable_password'] = $this->data['attrs']['disable_password'] ?: !\RightNow\Utils\Config::getConfig((193));
$this->data['username'] = \RightNow\Utils\Url::getParameter('username');
}
}
function _standard_login_LoginDialog_header() {
$result = array( 'js_name' => 'RightNow.Widgets.LoginDialog', 'library_name' => 'LoginDialog', 'view_func_name' => '_standard_login_LoginDialog_view', 'meta' => array ( 'controller_path' => 'standard/login/LoginDialog', 'view_path' => 'standard/login/LoginDialog', 'js_path' => 'standard/login/LoginDialog', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/LoginDialog.css', ), 'version' => '1.1.2', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(42108)', 'urlParameters' => array ( 'redirect' => array ( 'name' => 'rn:msg:(3354)', 'description' => 'rn:msg:(1761)', 'example' => 'redirect/home', ), 'username' => array ( 'name' => 'rn:msg:(4846)', 'description' => 'rn:msg:(3199)', 'example' => 'username/JohnDoe', ), ), ), 'relativePath' => 'standard/login/LoginDialog', 'widget_name' => 'LoginDialog', ), );
$result['meta']['attributes'] = array( 'trigger_element' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'required' => true, 'inherited' => false, )), 'label_username' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4846), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4846), 'inherited' => false, )), 'label_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(40564), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(40564), 'inherited' => false, )), 'label_login_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2601), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2601), 'inherited' => false, )), 'label_cancel_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(9555), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(9555), 'inherited' => false, )), 'label_dialog_title' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3151), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3151), 'inherited' => false, )), 'label_assistance' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2013), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2013), 'inherited' => false, )), 'disable_password' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'BOOLEAN', 'default' => false, 'inherited' => false, )), 'append_to_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'redirect_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'assistance_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((220)), 'type' => 'STRING', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((220)), 'inherited' => false, )), 'open_login_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((229)), 'type' => 'STRING', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((229)), 'inherited' => false, )), 'label_open_login_link' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage((2591)) . "<span class='rn_ScreenReaderOnly'>" . \RightNow\Utils\Config::getMessage((40417)) . ' ' . \RightNow\Utils\Config::getMessage((1354)) . '</span>', 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage((2591)) . "<span class='rn_ScreenReaderOnly'>" . \RightNow\Utils\Config::getMessage((40417)) . ' ' . \RightNow\Utils\Config::getMessage((1354)) . '</span>', 'inherited' => false, )), 'login_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajaxRequest/doLogin', 'type' => 'AJAX', 'default' => '/ci/ajaxRequest/doLogin', 'inherited' => false, )), 'disable_password_autocomplete' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), );
return $result;
}
}
namespace{
use \RightNow\Utils\FileSystem;
?><!DOCTYPE html>
<html lang="<?=\RightNow\Utils\Text::getLanguageCode();?>">
<head class="no-js">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; user-scalable=no; minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Contact Us | FAQs</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!--[if lt IE 9]><script type="text/javascript" src="/euf/rightnow/html5.js"></script><![endif]-->
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/BrowserSearchPlugin',
array('pages' => 'home, answers/list, answers/detail',));
?>
    <?= \RightNow\Libraries\SEO::getCanonicalLinkTag() . "\n";
?>
<style type='text/css'>
 <!-- 
.rn_ScreenReaderOnly{position:absolute; height:1px; left:-10000px; overflow:hidden; top:auto; width:1px;}
.rn_Hidden{display:none;}
 --></style>
<base href='<?=\RightNow\Utils\Url::getShortEufBaseUrl('sameAsRequest', \RightNow\Utils\FileSystem::getOptimizedAssetsDir() . 'themes/standard/');?>'/>
<link href='<?=FileSystem::getOptimizedAssetsDir();?>templates/standard.themes.standard.SITE.css' rel='stylesheet' type='text/css' media='all'/>
<style type="text/css">
<!--
.rn_LoginDialog{width: 210px;}
.rn_LoginDialog.rn_ContentLoading{background:url(<?=FileSystem::getOptimizedAssetsDir();?>themes/standard/images/loading.gif) no-repeat center center;}
.rn_LoginDialog input{margin-bottom:5px;}
.rn_LoginDialog input[type="text"], .rn_LoginDialog input[type="password"]{width:200px;}
.rn_LoginDialog label{margin-bottom:5px;display:block;}
.rn_LoginDialog div{margin-bottom: 5px;}
.rn_LoginDialog.rn_AdditionalOpenLogin{overflow: hidden;position: relative;width: 400px;}
.rn_LoginDialog.rn_AdditionalOpenLogin .rn_LoginDialogContent{border-left: 1px solid #DDD;float: right;margin-bottom: 5px;padding-left:32px;width:209px;}
.rn_LoginDialog div.rn_OpenLoginAlternative{background:url(<?=FileSystem::getOptimizedAssetsDir();?>themes/standard/images/icons/badges.png) no-repeat;border: 0;float: left;margin:4px;padding: 0;width: 150px;}
.rn_LoginDialog .rn_OpenLoginAlternative a{display: block;padding-top:80px;}
.rn_HighContrastMode .rn_LoginDialog .rn_OpenLoginAlternative a{padding-top: 0;}
.rn_HighContrastMode .rn_LoginDialog .rn_OpenLoginAlternative .rn_ScreenReaderOnly{position: static;}
.rn_EmailCredentials label{font-weight:bold;}
.rn_EmailCredentials label, .rn_EmailCredentials input{display:block;}
.rn_EmailCredentials .rn_Loading{background:url(<?=FileSystem::getOptimizedAssetsDir();?>themes/standard/images/indicator.gif) no-repeat left center;min-height:16px;min-width:16px;}
.rn_EmailCredentials input[type="text"]{margin:2px 0;padding: 2px;width: 250px;}
.rn_EmailCredentialsSuccessDialog{width: 450px;}
-->
</style>
9c1379bc-cca6-4750-aee7-188f8348a6c3
    <link rel="shortcut icon" href="https://www.virginamerica.com/images/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="//cloud.typography.com/6612472/735824/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="/euf/assets/themes/standard/header.css">
	
	<script type='text/javascript'>window.ATGSvcs = {'eeid': 200106296983};</script>
	<script type='text/javascript' src='//static.atgsvcs.com/js/atgsvcs.js'></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
       <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
       <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
</head>
<body class="yui-skin-sam yui3-skin-sam">
<!-- TagMan BootStrap -->
<script type="text/javascript">
   var webData = {
      pageName: "Contact Us",
      siteSection: 'Contact Us',
      servEnv: 'Oracle'
   }
   window.tmParam = {};
   (function(d,s){
      var client = 'virginamerica';
      var siteId = 20;
      //  do not edit
      var a=d.createElement(s),b=d.getElementsByTagName(s)[0];
      a.async=true;a.type='text/javascript';
      a.src='//sec.levexis.com/clients/'+client+'/'+siteId+'.js';
      a.tagman='st='+(+new Date())+'&c='+client+'&sid='+siteId;
      b.parentNode.insertBefore(a,b);
   })(document,'script');
</script>
<script type="text/javascript">
  function toggleLinks(id) {
    var e = document.getElementById(id);
    var body = document.getElementById('rn_Body');
    var ele = document.querySelector("#vx-wrapper");
    if (e.style.display == 'block') {
      e.style.display = 'none';
      body.style.display = 'block';
      ele.style.backgroundColor = 'transparent';     
    }
    else {
      e.style.display = 'block';
      body.style.display = 'none';
      ele.style.backgroundColor = "#DF1A2D";
    }
  }
</script>
<div id="rn_Container" >
    <div id="rn_SkipNav"><a href="#rn_MainContent"><?=\RightNow\Utils\Config::msgGetFrom((3673));?></a></div>
    <div id="rn_Header" role="banner">
    <noscript><h1><?=\RightNow\Utils\Config::msgGetFrom((4861));?></h1></noscript>
    <!--    <div id="rn_Logo"><a href="/app/<?=\RightNow\Utils\Config::configGetFrom((226));?><?=\RightNow\Utils\Url::sessionParameter();?>"><span class="rn_LogoTitle"><?=\RightNow\Utils\Config::msgGetFrom((8290));?> <span class="rn_LogoTitleMinor"><?=\RightNow\Utils\Config::msgGetFrom((14049));?></span></span></a></div> -->
        <header role="banner" class="banner">
            <h1 class="navbar__logo">
                <a href="https://www.virginamerica.com/">Virgin America</a>
            </h1>
            <nav class="navbar__main cf">
                <ul class="navlist--main cf">
                    <li><a href="https://www.virginamerica.com/cms/book-travel">Book</a></li>
                    <li><a href="https://www.virginamerica.com/flight-check-in">Check In</a></li>
                    <li><a href="https://www.virginamerica.com/manage-itinerary">Manage</a></li>
                </ul>
                <ul class="navlist--sub cf">
                    <li><a href="https://www.virginamerica.com/cms/travel-deals">Deals</a></li>
                    <li><a href="https://www.virginamerica.com/cms/fly-with-us">Flying With Us</a></li>
                    <li><a href="https://www.virginamerica.com/cms/airport-destinations">Where We Fly</a></li>
                    <li><a href="https://www.virginamerica.com/cms/vx-fees" target="">Fees</a></li>
                    <li><a href="https://www.virginamerica.com/check-flight-status">Flight Status</a></li>
                    <li><a href="https://www.virginamerica.com/get-flight-alerts">Flight Alerts</a></li>
                </ul>
            </nav>
            <div class="navbar__right cf">
                <div class="navbar__expand-nav">
                    <a href="#" class="expand-nav icon-nav-toggle">Nav</a>
                </div>
                <div class="navbar__elevate-nav">
                    <span class="elevate-nav--logged-out cf">
                        <a href="https://www.virginamerica.com/cms/elevate-frequent-flyer" class="elevate-nav__link elevate-nav__link--about icon-elevate-small">About Elevate</a>
                        <a href="https://www.virginamerica.com/elevate-frequent-flyer" class="elevate-nav__link elevate-nav__link--sign-in icon-elevate-small">Sign In</a>
                        <a href="https://www.virginamerica.com/elevate-frequent-flyer/sign-up" class="elevate-nav__link" ng-show="header.breakpoint !== 'small'">Sign Up</a>
                    </span>
                </div>
                <div class="navbar__elevate-nav is-close">
                    <a href="#" class="elevate-nav--close icon-close-light-white"></a>
                </div>
            </div>
            <nav class="nav-dropdown is-hidden">
                <div class="nav-expanded">
                    <ul class="nav-expanded__list">
                        <li>
                            <a href="https://www.virginamerica.com/">Home</a>
                        </li>
                        <li>
                            <a href="https://www.virginamerica.com/cms/book-travel">Book</a>
                        </li>
                        <li>
                            <a href="https://www.virginamerica.com/flight-check-in">Check In</a>
                        </li>
                        <li>
                            <a href="https://www.virginamerica.com/manage-itinerary">Manage</a>
                        </li>
                    </ul>
                    <ul class="nav-expanded__list--sub">
                        <li><a href="https://www.virginamerica.com/cms/travel-deals">Deals</a></li>
                        <li><a href="https://www.virginamerica.com/cms/fly-with-us">Flying With Us</a></li>
                        <li><a href="https://www.virginamerica.com/cms/airport-destinations">Where We Fly</a></li>
                        <li><a href="https://www.virginamerica.com/cms/vx-fees">Fees</a></li>
                        <li><a href="https://www.virginamerica.com/check-flight-status">Flight Status</a></li>
                        <li><a href="https://www.virginamerica.com/get-flight-alerts">Flight Alerts</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <div id="rn_LoginStatus">
            <?if(
(\RightNow\Utils\Framework::isLoggedIn()) ):?>
                 <?=\RightNow\Utils\Config::msgGetFrom((4605));?>
                <strong>
                    <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Contact', 1 => 'LookupName', ), false);?>
                </strong>
                <div>
                    <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array
( 0 => 'Contact', 1 => 'Organization', 2 => 'Name', ), false);?>
                </div>
                <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/LogoutLink',
array());
?>
            <?else:?>
                <?if( (\RightNow\Utils\Config::getConfig(372) == true) ):?>
                    <a href="javascript:void(0);" id="rn_LoginLink"><?=\RightNow\Utils\Config::msgGetFrom((2601));?></a>&nbsp;|&nbsp;<a href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((3650));?></a>
                <?else:?>
                    <a href="javascript:void(0);" id="rn_LoginLink"><?=\RightNow\Utils\Config::msgGetFrom((2601));?></a>&nbsp;|&nbsp;<a href="/app/utils/create_account<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((3650));?></a>
                    <?if(
((get_instance()->page !== 'utils/create_account') && (get_instance()->page !== 'utils/login_form') && (get_instance()->page !== 'utils/account_assistance') ) ):?>
                        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/LoginDialog', array('trigger_element' => 'rn_LoginLink','open_login_url' => '/app/' . \RightNow\Utils\Config::configGetFrom((229)) . '','label_open_login_link' => '' . \RightNow\Utils\Config::msgGetFrom((2591)) . ' <span class=\'rn_ScreenReaderOnly\'>(Facebook, Twitter, Google, OpenID) ' . \RightNow\Utils\Config::msgGetFrom((1354)) . '</span>',));
?>
                    <?endif;?>
                    <?if(
((get_instance()->page === 'utils/create_account') || (get_instance()->page === 'utils/login_form') || (get_instance()->page === 'utils/account_assistance') ) ):?>
                        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/LoginDialog', array('trigger_element' => 'rn_LoginLink','redirect_url' => '/app/account/overview','open_login_url' => '/app/' . \RightNow\Utils\Config::configGetFrom((229)) . '','label_open_login_link' => '' . \RightNow\Utils\Config::msgGetFrom((2591)) . ' <span class=\'rn_ScreenReaderOnly\'>(Facebook, Twitter, Google, OpenID) ' . \RightNow\Utils\Config::msgGetFrom((1354)) . '</span>',));
?>
                    <?endif;?>
                <?endif;?>
            <?endif;?>
        </div>
    </div>
    <div id="rn_Body">
        <div id="rn_MainColumn" role="main">
            <a id="rn_MainContent"></a>
<div id="rn_PageTitle" class="rn_Account">
    <h1><?=\RightNow\Utils\Config::msgGetFrom((901));?></h1>
</div>
<div id="rn_PageContent" class="rn_Account">
    <div class="rn_Padding" >
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/EmailCredentials',
array('credential_type' => 'username','label_heading' => '' . \RightNow\Utils\Config::msgGetFrom((3400)) . '','label_description' => '' . \RightNow\Utils\Config::msgGetFrom((1705)) . '','label_button' => '' . \RightNow\Utils\Config::msgGetFrom((1737)) . '','label_input' => '' . \RightNow\Utils\Config::msgGetFrom((4547)) . '','initial_focus' => 'true',));
?>
        <br/>
        <br/>
        <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/EmailCredentials', array());
?>
    </div>
</div>
        </div>
<!--
        <rn:condition hide_on_pages="app/ask">
        <div id="rn_SideBar" role="navigation">
            <div class="rn_Padding">
                <div class="rn_Module">
                  <h2>Top 10 Questions</h2>
                    <rn:widget path="reports/Multiline2" report_id="194" per_page="10"/>
                </div>
            </div>
        </div>
        </rn:condition>
-->
    </div>
    <div id="rn_Footer" role="contentinfo">
<!--
        <div id="rn_RightNowCredit">
            <div class="rn_FloatRight">
                <rn:widget path="utils/RightNowLogo"/>
            </div>
        </div> -->
        <footer class="vx-footer">
            <div class="vx-wrap desktop">
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/sitemap/" target="_self">Site Map</a></li>
                    <li><a href="http://virginamerica.custhelp.com/" target="_self">Contact Us/FAQs</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline" target="_self">About Us</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline/press/" target="_self">Press</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/blog" target="_self">Blog</a></li>
                    <li><a href="http://www.virginamerica.com/cms/airline-jobs/" target="_self">Careers</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel" target="_self">Corporate Travel</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/travel-agents" target="_self">Travel Agents</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/legal/guest-service-commitment" target="_self">Guest Service Commitment</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/contract-of-carriage.pdf/">Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/international-contract-of-carrage.pdf">Int’l Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/groups-meetings/" target="_self">Group Travel</a></li>
                </ul>
                <ul>
                    <li><a href="https://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGn0oWPReMY4XDaNwzdUWuzby0minVXMtX%3DWQpglLjHJlYQGiTzdzegm6dhzeeqzbYgKaeKzd0SzdkO&_ei_=EqJbYT9NhKIwWY6KwuLgbGM">Email Unsubscribe</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/privacy-policy" target="_self">Privacy Policy</a></li>
                    <li><a href="http://www.virginamerica.com/cms/travel-guard" target="_self">Travel Insurance</a></li>
                    <li><a href="http://www.virginamerica.com/cms/news" target="_self">All News &amp; Updates</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/elevate-frequent-flyer" target="_self">What is Elevate?</a></li>
                    <li><a href="http://www.virginamerica.com/elevate-frequent-flyer/credit-card" target="_self">VirginAmerica Credit Card</a></li>
                    <li><a href="http://www.virginamerica.com/cms/advertise-onboard/" target="_self">Advertise Onboard</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-responsibility/" target="_self">Corporate Responsibility</a></li>
                </ul>
                <ul>
                    <li><a href="http://instagram.com/virginamerica" target="_blank" >Instagram</a></li>
                    <li><a href="http://twitter.com/VirginAmerica" target="_blank" >Twitter</a></li>
                    <li><a href="http://www.facebook.com/VirginAmerica" target="_blank" >Facebook</a></li>
                    <li><a href="http://www.youtube.com/user/VirginAmerica" target="_blank" >YouTube</a></li>
                </ul>
            </div>
            <div class="vx-wrap tablet">
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/sitemap/" target="_self">Site Map</a></li>
                    <li><a href="http://virginamerica.custhelp.com/" target="_self">Contact Us/FAQs</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline" target="_self">About Us</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline/press/" target="_self">Press</a></li>
                    <li><a href="/blog" target="_self">Blog</a></li>
                    <li><a href="http://www.virginamerica.com/cms/airline-jobs/" target="_self">Careers</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel" target="_self">Corporate Travel</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/travel-agents" target="_self">Travel Agents</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/guest-service-commitment" target="_self">Guest Service Commitment</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/contract-of-carriage.pdf/">Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/international-contract-of-carrage.pdf">Int’l Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/groups-meetings/" target="_self">Group Travel</a></li>
                </ul>
                <ul>
                    <li><a href="https://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGn0oWPReMY4XDaNwzdUWuzby0minVXMtX%3DWQpglLjHJlYQGiTzdzegm6dhzeeqzbYgKaeKzd0SzdkO&_ei_=EqJbYT9NhKIwWY6KwuLgbGM">Email Unsubscribe</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/privacy-policy" target="_self">Privacy Policy</a></li>
                    <li><a href="http://www.virginamerica.com/cms/travel-guard" target="_self">Travel Insurance</a></li>
                    <li><a href="http://www.virginamerica.com/cms/news" target="_self">All News &amp; Updates</a></li>
                    <li><a href="http://www.virginamerica.com/cms/elevate-frequent-flyer" target="_self">What is Elevate?</a></li>
                    <li><a href="http://www.virginamerica.com/elevate-frequent-flyer/credit-card" target="_self">VirginAmerica Credit Card</a></li>
                </ul>
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/advertise-onboard/" target="_self">Advertise Onboard</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-responsibility/" target="_self">Corporate Responsibility</a></li>
                    <li><a href="http://instagram.com/virginamerica" target="_blank" >Instagram</a></li>
                    <li><a href="http://twitter.com/VirginAmerica" target="_blank" >Twitter</a></li>
                    <li><a href="http://www.facebook.com/VirginAmerica" target="_blank" >Facebook</a></li>
                    <li><a href="http://www.youtube.com/user/VirginAmerica" target="_blank" >YouTube</a></li>
                </ul>
            </div>        
            <div class="vx-wrap mobile">
                <ul>
                    <li><a href="http://www.virginamerica.com/cms/sitemap/" target="_self">Site Map</a></li>
                    <li><a href="http://virginamerica.custhelp.com/" target="_self">Contact Us/FAQs</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline" target="_self">About Us</a></li>
                    <li><a href="http://www.virginamerica.com/cms/about-our-airline/press/" target="_self">Press</a></li>
                    <li><a href="http://www.virginamerica.com/blog" target="_self">Blog</a></li>
                    <li><a href="http://www.virginamerica.com/cms/airline-jobs/" target="_self">Careers</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel" target="_self">Corporate Travel</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/travel-agents" target="_self">Travel Agents</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/guest-service-commitment" target="_self">Guest Service Commitment</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/contract-of-carriage.pdf/">Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/dam/xv-pdf/international-contract-of-carrage.pdf">Int’l Contract of Carriage</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-travel/groups-meetings/" target="_self">Group Travel</a></li>
                </ul>
                <ul>
                    <li><a href="https://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGn0oWPReMY4XDaNwzdUWuzby0minVXMtX%3DWQpglLjHJlYQGiTzdzegm6dhzeeqzbYgKaeKzd0SzdkO&_ei_=EqJbYT9NhKIwWY6KwuLgbGM">Email Unsubscribe</a></li>
                    <li><a href="http://www.virginamerica.com/cms/legal/privacy-policy" target="_self">Privacy Policy</a></li>
                    <li><a href="http://www.virginamerica.com/cms/travel-guard" target="_self">Travel Insurance</a></li>
                    <li><a href="http://www.virginamerica.com/cms/news" target="_self">All News &amp; Updates</a></li>
                    <li><a href="http://www.virginamerica.com/cms/elevate-frequent-flyer" target="_self">What is Elevate?</a></li>
                    <li><a href="http://www.virginamerica.com/elevate-frequent-flyer/credit-card" target="_self">VirginAmerica Credit Card</a></li>
                    <li><a href="http://www.virginamerica.com/cms/advertise-onboard/" target="_self">Advertise Onboard</a></li>
                    <li><a href="http://www.virginamerica.com/cms/corporate-responsibility/" target="_self">Corporate Responsibility</a></li>
                    <li><a href="http://instagram.com/virginamerica" target="_blank" >Instagram</a></li>
                    <li><a href="http://twitter.com/VirginAmerica" target="_blank" >Twitter</a></li>
                    <li><a href="http://www.facebook.com/VirginAmerica" target="_blank" >Facebook</a></li>
                    <li><a href="http://www.youtube.com/user/VirginAmerica" target="_blank" >YouTube</a></li>
                </ul>
            </div>
            <p class="copyright">© 2014 Virgin America</p>
        </footer>
    </div>
</div>
      <footer role="contentinfo">
            <div class="wrap">
                <div class="footer-wrap">
                    <nav class="footer-nav cf">
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/sitemap">Sitemap</a></li>
                            <li class="footer-nav__item"><a href="http://virginamerica.custhelp.com/">Contact Us/FAQs</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/about-our-airline">About Us</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/about-our-airline/press">Press</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/blog">Blog</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/airline-jobs">Careers</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/corporate-travel">Corporate &amp; Group Travel</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/corporate-travel/travel-agents">Travel Agents</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/legal/guest-service-commitment">Guest Service Commitment</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/dam/vx-pdf/contract-of-carriage.pdf">Contract of Carriage</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/dam/vx-pdf/international-contract-of-carriage.pdf">Int’l Contract of Carriage</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/corporate-responsibility">Corporate Responsibility</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="http://elevate.virginamerica.com/pub/sf/ResponseForm?_ri_=X0Gzc2X%3DWQpglLjHJlYQGmAt9ur9biu27Jh9e9uzfeDcCi8SonfVXMtX%3DWQpglLjHJlYQGruK1w1EzbazdUdEGG6gmlazdJwoNGDzbf&_ei_=EmSL9xUrhFrGHt6VuHz0Fpo">Email Unsubscribe</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/legal/privacy-policy">Privacy Policy</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/travel-guard">Travel Insurance</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/news">All News &amp; Updates</a></li>
                        </ul>
                        <ul class="footer-nav__list">
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/elevate-frequent-flyer">What Is Elevate?</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/elevate-frequent-flyer/credit-card">Virgin America Credit Card</a></li>
                            <li class="footer-nav__item"><a href="https://www.virginamerica.com/cms/advertise-onboard">Advertise Onboard</a></li>
                            <li class="footer-nav__item"><a href="https://plus.google.com/+VirginAmerica/" target="_blank" rel="publisher">Google+</a></li>
                        </ul>
                        <ul class="footer-nav__list is-omega">
                            <li class="footer-nav__item"><a href="http://instagram.com/virginamerica" target="_blank" rel="me">Instagram</a></li>
                            <li class="footer-nav__item"><a href="https://twitter.com/VirginAmerica" target="_blank" rel="me">Twitter</a></li>
                            <li class="footer-nav__item"><a href="https://www.facebook.com/VirginAmerica" target="_blank" rel="me">Facebook</a></li>
                            <li class="footer-nav__item"><a href="https://www.youtube.com/user/VirginAmerica" target="_blank" rel="me">YouTube</a></li>
                        </ul>
                    </nav>
                    <div class="footer-copy">
                        &copy; 2014 Virgin America
                    </div>
                </div>
            </div>
        </footer>
        <script>
	        //document.body.scrollTop = document.documentElement.scrollTop = 0;
        /*  var $jq = jQuery.noConflict(true);
		  jQuery( document ).ready(function() {
                $dropdown = $('.nav-dropdown')
                $('.navbar__expand-nav').on('click', 'a', function (e) {
                    e.preventDefault();
                    $dropdown.toggleClass('is-hidden');
                    $('body').toggleClass('is-modal-open');
                    $('.banner').toggleClass('is-nav-expanded-active');
                });
                var getDeviceWindowHeight = function () {
                  var zoomLevel = document.documentElement.clientWidth / window.innerWidth;
                  return window.innerHeight * zoomLevel;
                }
                var applyWinHeight = function () {
                  $dropdown.css(
                    'height',
                    (getDeviceWindowHeight() - 54) + 'px'
                  );
                };
                applyWinHeight();
                $(window).resize(function () {
                    applyWinHeight();
                });
            })(); */
        </script>
<?=get_instance()->clientLoader->getYuiConfiguration();?><script type="text/javascript" src="<?=\RightNow\Utils\Url::getCoreAssetPath('js/4.171/min/RightNow.js');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>templates<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/login/LogoutLink', 1 => 'standard/login/LoginDialog', ), '/standard.js', '1436802870');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/login/EmailCredentials', ), '/utils/account_assistance.js', '1436802870');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'PCT_S_MUST_NOT_CONTAIN_SPACES_MSG' => array ( 'value' => 3042, ), 'USERNAME_LBL' => array ( 'value' => 4846, ), 'PCT_S_CONTAIN_DOUBLE_QUOTES_MSG' => array ( 'value' => 3005, ), 'PCT_S_CNT_THAN_MSG' => array ( 'value' => 3002, ), 'EMAIL_IS_NOT_VALID_MSG' => array ( 'value' => 1731, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
