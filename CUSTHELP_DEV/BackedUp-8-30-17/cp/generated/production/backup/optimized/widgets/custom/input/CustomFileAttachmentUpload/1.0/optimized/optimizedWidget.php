<? namespace Custom\Widgets\input;
\RightNow\Utils\Widgets::requireOptimizedWidgetController("standard/input/FileAttachmentUpload");
class CustomFileAttachmentUpload extends \RightNow\Widgets\FileAttachmentUpload {
function _custom_input_CustomFileAttachmentUpload_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
<div id="rn_<?=$this->instanceID;?>_child" class="<?=
$this->classList ?> <? if(!$this->data['attrs']['always_show']): echo('rn_Hidden');
endif;?>">
    <div id="rn_<?=
$this->instanceID ?>_LabelContainer">
        <label for="rn_<?=$this->instanceID;?>_FileInput" id="rn_<?=$this->instanceID;?>_Label"><?=$this->data['attrs']['label_input'];?>
        <?
if($this->data['attrs']['min_required_attachments'] > 0):?>
            <span class="rn_Required"> <?=\RightNow\Utils\Config::getMessage((1908));?> </span><span class="rn_ScreenReaderOnly"><?=\RightNow\Utils\Config::getMessage((7015))?></span>
        <?
endif;?>
        </label>
    </div>
    <input name="file" id="rn_<?=$this->instanceID;?>_FileInput" type="file"/>
    <?
if($this->data['attrs']['loading_icon_path']):?>
    <img id="rn_<?=$this->instanceID;?>_LoadingIcon" class="rn_Hidden" alt="" src="<?=$this->data['attrs']['loading_icon_path'];?>" />
    <?
endif;?>
    <span id="rn_<?=$this->instanceID;?>_StatusMessage"></span>
</div>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
return parent::getData();
}
}
function _custom_input_CustomFileAttachmentUpload_header() {
$result = array( 'js_name' => 'Custom.Widgets.input.CustomFileAttachmentUpload', 'library_name' => 'CustomFileAttachmentUpload', 'view_func_name' => '_custom_input_CustomFileAttachmentUpload_view', 'meta' => array ( 'controller_path' => 'custom/input/CustomFileAttachmentUpload', 'view_path' => 'custom/input/CustomFileAttachmentUpload', 'js_path' => 'custom/input/CustomFileAttachmentUpload', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/CustomFileAttachmentUpload.css', ), 'base_css' => array ( 0 => 'custom/input/CustomFileAttachmentUpload/base.css', ), 'version' => '1.0', 'requires' => array ( 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'extends' => array ( 'widget' => 'standard/input/FileAttachmentUpload', 'components' => array ( 'php' => true, 'view' => true, 'js' => true, 'css' => true, ), ), 'relativePath' => 'custom/input/CustomFileAttachmentUpload', 'extends_info' => array ( 'controller' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'view' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'logic' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'js_templates' => array ( 0 => array ( 'attachmentItem' => '<li id="<%= id %>"> <rn:block id="attachmentItemTop"/> <% if (displayThumbnail) { %> <rn:block id="preThumbnail"/> <span class="rn_Thumbnail"></span> <rn:block id="postThumbnail"/> <% } %> <rn:block id="preFileName"/> <%= name %> <rn:block id="postFileName"/> <rn:block id="preRemoveLink"/> <a href=\'javascript:void(0)\' class=\'rn_fileRemove\'><%= attrs.label_remove %><span class=\'rn_ScreenReaderOnly\'><%= name %></span></a> <rn:block id="postRemoveLink"/> <rn:block id="attachmentItemBottom"/></li>', 'error' => '<div data-field="<%= fieldName %>"> <rn:block id="preError"/> <b><a href=\'javascript:void(0);\' onclick=\'document.getElementById("<%= id %>").focus(); return false;\'><%= errorLink %></a></b> <rn:block id="postError"/></div>', 'label' => '<rn:block id="preFileInputLabel"/><label for="rn_<%= instanceID %>_FileInput" id="rn_<%= instanceID %>_Label"><%= label %><% if(minAttachments) { %> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span><% } %></label><rn:block id="postFileInputLabel"/>', 'maxMessage' => '<li> <rn:block id="preMaxLabel"/> <%= maxMessage %> <rn:block id="postMaxLabel"/></li>', ), ), 'base_css' => array ( 0 => 'standard/input/FileAttachmentUpload/base.css', ), 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/FileAttachmentUpload.css', 1 => 'assets/themes/mobile/widgetCss/FileAttachmentUpload.css', ), 'parent' => 'standard/input/FileAttachmentUpload', ), 'widget_name' => 'CustomFileAttachmentUpload', 'extends_php' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'extends_js' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'extends_view' => array ( 0 => 'standard/input/FileAttachmentUpload', ), 'parent' => 'standard/input/FileAttachmentUpload', 'js_templates' => array ( 'attachmentItem' => '<li id="<%= id %>">  <% if (displayThumbnail) { %>  <span class="rn_Thumbnail"></span>  <% } %>  <%= name %>   <a href=\'javascript:void(0)\' class=\'rn_fileRemove\'><%= attrs.label_remove %><span class=\'rn_ScreenReaderOnly\'><%= name %></span></a>  </li>', 'error' => '<div data-field="<%= fieldName %>">  <b><a href=\'javascript:void(0);\' onclick=\'document.getElementById("<%= id %>").focus(); return false;\'><%= errorLink %></a></b> </div>', 'label' => '<label for="rn_<%= instanceID %>_FileInput" id="rn_<%= instanceID %>_Label"><%= label %><% if(minAttachments) { %> <span class="rn_Required"> <%= requiredMarkLabel %></span><span class="rn_ScreenReaderOnly"><%= requiredLabel %></span><% } %></label>', 'maxMessage' => '<li>  <%= maxMessage %> </li>', ), ), );
$result['meta']['attributes'] = array( 'always_show' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => false, )), 'display_value' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'string', 'default' => '', 'inherited' => false, )), 'label_input' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4480), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4480), 'inherited' => true, )), 'label_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'label_remove' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(6896), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(6896), 'inherited' => true, )), 'max_attachments' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => true, )), 'label_max_attachment_limit' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(3336), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(3336), 'inherited' => true, )), 'label_generic_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1941), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1941), 'inherited' => true, )), 'label_still_uploading_error' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(43242), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(43242), 'inherited' => true, )), 'loading_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/indicator.gif', 'type' => 'FILEPATH', 'default' => 'images/indicator.gif', 'inherited' => true, )), 'min_required_attachments' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 0, 'type' => 'INT', 'default' => 0, 'inherited' => true, )), 'label_min_required' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(18887), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(18887), 'inherited' => true, )), 'valid_file_extensions' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => true, )), 'label_invalid_extension' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2004), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2004), 'inherited' => true, )), 'display_thumbnail' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => true, )), 'max_thumbnail_height' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 100, 'type' => 'INT', 'default' => 100, 'inherited' => true, )), 'hide_on_load' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => false, 'type' => 'boolean', 'default' => false, 'inherited' => true, )), );
return $result;
}
