<?php
namespace Custom\Widgets\chat;
class ChatAgentCustomAvail extends \RightNow\Libraries\Widget\Base {
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