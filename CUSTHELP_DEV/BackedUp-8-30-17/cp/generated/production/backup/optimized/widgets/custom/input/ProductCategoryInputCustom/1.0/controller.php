<?php  namespace Custom\Widgets\input;
use RightNow\Utils\Url, RightNow\Utils\Text;
class ProductCategoryInputCustom extends \RightNow\Libraries\Widget\Input {
const PRODUCT = 'Product';
const CATEGORY = 'Category';
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
$dataType = $this->data['attrs']['data_type'] = (Text::stringContains(strtolower($this->data['attrs']['data_type']), 'prod')) ? self::PRODUCT : self::CATEGORY;
if ($this->data['attrs']['data_type'] === self::CATEGORY) {
$this->data['attrs']['label_all_values'] = ($this->data['attrs']['label_all_values'] === \RightNow\Utils\Config::getMessage((843))) ? \RightNow\Utils\Config::getMessage((842)) : $this->data['attrs']['label_all_values'];
$this->data['attrs']['label_input'] = ($this->data['attrs']['label_input'] === \RightNow\Utils\Config::getMessage((4594))) ? \RightNow\Utils\Config::getMessage((4574)) : $this->data['attrs']['label_input'];
$this->data['attrs']['label_nothing_selected'] = ($this->data['attrs']['label_nothing_selected'] === \RightNow\Utils\Config::getMessage((3532))) ? \RightNow\Utils\Config::getMessage((3529)) : $this->data['attrs']['label_nothing_selected'];
}
if ($this->data['attrs']['table'] === 'contacts') {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((40942)), 'contacts', 'table'));
return false;
}
$this->data['js']['name'] = $this->data['attrs']['name'] = "Incident.{$this->data['attrs']['data_type']}";
if (parent::getData() === false) return false;
if (!in_array($this->dataType, array('ServiceProduct', 'ServiceCategory'))) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((40365)), $this->fieldName));
return false;
}
if($this->data['attrs']['required_lvl'] > $this->data['attrs']['max_lvl']) {
echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage((4119)), "required_lvl", "max_lvl", "max_lvl", "required_lvl", $this->data['attrs']['required_lvl']));
$this->data['attrs']['max_lvl'] = $this->data['attrs']['required_lvl'];
}
if($this->data['attrs']['hint'] && strlen(trim($this->data['attrs']['hint']))){
$this->data['js']['hint'] = $this->data['attrs']['hint'];
}
$trimmedTreeViewCss = trim($this->data['attrs']['treeview_css']);
if ($trimmedTreeViewCss !== '') $this->addStylesheet($trimmedTreeViewCss);
$this->data['js']['linkingOn'] = $this->data['attrs']['linking_off'] ? 0 : $this->CI->model('Prodcat')->getLinkingMode();
$this->data['js']['hm_type'] = ($dataType === self::PRODUCT) ? (13) : (14);
$maxLevel = $this->data['attrs']['max_lvl'];
$defaultChain = $this->getDefaultChain();
if($this->data['js']['linkingOn'] && $dataType === self::CATEGORY) {
$defaultProductID = $this->CI->model('Prodcat')->getDefaultProductID() ?: null;
$this->data['js']['link_map'] = $defaultHierMap = $this->CI->model('Prodcat')->getFormattedTree($dataType, $defaultChain, true, $defaultProductID, $maxLevel)->result;
$this->data['js']['hierDataNone'] = $this->CI->model('Prodcat')->getFormattedTree($dataType, array(), true, null, $maxLevel)->result;
array_unshift($this->data['js']['hierDataNone'][0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
array_unshift($this->data['js']['link_map'][0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
}
else {
if($dataType === self::PRODUCT) {
$this->CI->model('Prodcat')->setDefaultProductID(end($defaultChain));
}
$defaultHierMap = $this->CI->model('Prodcat')->getFormattedTree($dataType, $defaultChain, false, null, $maxLevel)->result;
}
array_unshift($defaultHierMap[0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
$this->data['js']['hierData'] = $defaultHierMap;
}
protected function getDefaultChain() {
$dataType = $this->data['attrs']['data_type'];
$shortDataType = ($dataType === self::PRODUCT) ? 'prod' : 'cat';
$defaultValue = null;
$postKeys = array( "Incident_$dataType", "incidents_$shortDataType", $shortDataType[0], );
$urlKeys = array( "Incident.$dataType", "incidents.$shortDataType", $shortDataType[0], );
foreach ($postKeys as $key) {
$postParam = $this->CI->input->post($key);
if ($postParam !== false) {
$defaultValue = $postParam;
}
}
$incidentID = Url::getParameter('i_id');
if (($defaultValue === false || $defaultValue === null) && $incidentID && $incident = $this->CI->model('Incident')->get($incidentID)->result) {
$incidentValue = $incident->{$dataType}->ID;
if ($incidentValue) {
$defaultValue = $incidentValue;
}
}
if ($defaultValue === false || $defaultValue === null) {
foreach ($urlKeys as $key) {
$urlParam = Url::getParameter($key);
if ($urlParam !== null) {
$defaultValue = $urlParam;
}
}
}
if ($defaultValue === false || $defaultValue === null) {
$defaultFromAttribute = $this->data['attrs']['default_value'];
if ($defaultFromAttribute !== false) {
$defaultValue = $defaultFromAttribute;
}
}
if($defaultValue) {
$defaultChain = explode(',', $defaultValue);
$defaultChain = (count($defaultChain) === 1) ? $this->CI->model('Prodcat')->getFormattedChain($dataType, $defaultChain[0], true)->result : $this->CI->model('Prodcat')->getEnduserVisibleHierarchy($defaultChain)->result;
if(count($defaultChain) > $this->data['attrs']['max_lvl']) {
$defaultChain = array_splice($defaultChain, 0, $this->data['attrs']['max_lvl']);
}
}
return $defaultChain ?: array();
}
}
