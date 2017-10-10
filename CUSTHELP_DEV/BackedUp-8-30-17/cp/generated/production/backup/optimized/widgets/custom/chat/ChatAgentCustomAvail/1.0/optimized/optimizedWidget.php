<? namespace Custom\Widgets\chat;
class ChatAgentCustomAvail extends \RightNow\Libraries\Widget\Base {
function _custom_chat_ChatAgentCustomAvail_view ($data) {
extract($data);
?><? }
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$chatProduct = "";
$chatCategory = "";
$contactID = '';
$orgID = "";
$contactEmail = "";
$contactFirstName = "";
$contactLastName = "";
$availType = "agents";
$isCacheable = "";
$callback = "";
$interfaceID = 1;
$cacheKey = implode('|', array($chatProduct, $chatCategory, $contactID, $orgID, $contactEmail, $contactFirstName, $contactLastName, $interfaceID));
$cache = new \RightNow\Libraries\Cache\Memcache(60);
if (($chatRouteRV = $cache->get($cacheKey)) === false) {
$chatRouteRV = $this->CI->model('Chat')->chatRoute($chatProduct, $chatCategory, $contactID, $orgID, $contactEmail, $contactFirstName, $contactLastName)->result;
$cache->set($cacheKey, $chatRouteRV);
}
$result = $this->CI->model('Chat')->checkChatQueue($chatRouteRV, $availType, $isCacheable)->result;
header("Cache-Control: max-age=0,no-cache,no-store");
if($callback) {
header("Content-Type: text/javascript;charset=UTF-8");
}
$this->data['js']['result']=$result['stats']['availableSessionCount'];
return parent::getData();
}
}
function _custom_chat_ChatAgentCustomAvail_header() {
$result = array( 'js_name' => 'Custom.Widgets.chat.ChatAgentCustomAvail', 'library_name' => 'ChatAgentCustomAvail', 'view_func_name' => '_custom_chat_ChatAgentCustomAvail_view', 'meta' => array ( 'controller_path' => 'custom/chat/ChatAgentCustomAvail', 'view_path' => '', 'js_path' => 'custom/chat/ChatAgentCustomAvail', 'base_css' => array ( 0 => 'custom/chat/ChatAgentCustomAvail/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'relativePath' => 'custom/chat/ChatAgentCustomAvail', 'widget_name' => 'ChatAgentCustomAvail', ), );
$result['meta']['attributes'] = array( );
return $result;
}
