<? namespace Custom\Widgets\search;
class CustomKeywordText extends \RightNow\Libraries\Widget\Base {
function _custom_search_CustomKeywordText_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=
$this->classList ?>">
    <label for="rn_<?=$this->instanceID;?>_Text"><?=$this->data['attrs']['label_text'];?></label>
    <input
      id="rn_<?=$this->instanceID;?>_Text"
      name="rn_<?=$this->instanceID;?>_Text"
    <?php
if (isset($this->data['attrs']['placeholder'])){
echo 'placeholder="' . $this->data['attrs']['placeholder'] . '"';
};
?>
 type="text"
    maxlength="255"
    value="<?=$this->data['js']['initialValue'];?>"
    />
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
\RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
$reportToken = \RightNow\Utils\Framework::createToken($this->data['attrs']['report_id']);
$searchTerm = $this->CI->model('Report')->getSearchTerm($this->data['attrs']['report_id'], $reportToken, $filters)->result;
$this->data['js'] = array( 'initialValue' => $searchTerm ?: '', 'rnSearchType' => 'keyword', 'searchName' => 'keyword', );
}
}
function _custom_search_CustomKeywordText_header() {
$result = array( 'js_name' => 'Custom.Widgets.search.CustomKeywordText', 'library_name' => 'CustomKeywordText', 'view_func_name' => '_custom_search_CustomKeywordText_view', 'meta' => array ( 'controller_path' => 'custom/search/CustomKeywordText', 'view_path' => 'custom/search/CustomKeywordText', 'js_path' => 'custom/search/CustomKeywordText', 'base_css' => array ( 0 => 'custom/search/CustomKeywordText/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'relativePath' => 'custom/search/CustomKeywordText', 'widget_name' => 'CustomKeywordText', ), );
$result['meta']['attributes'] = array( );
return $result;
}
