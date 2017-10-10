<?php
namespace{
get_instance()->themes->setRuntimeThemeData(array ( 0 => '/euf/assets/themes/mobile', 1 => '/euf/assets/themes/mobile', 2 => array ( '/euf/assets/themes/mobile' => '<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile', ), ));
get_instance()->_checkMeta(array('javascript_module'=>'mobile_may_10', 'title'=>'' . \RightNow\Utils\Config::msgGetFrom((6058)) . '', 'template'=>'mobile.php', 'clickstream'=>'post_view'));
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
class CommunityPostDisplay extends \RightNow\Libraries\Widget\Base {
function _standard_social_CommunityPostDisplay_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <? $post = $this->data['post'];?>
    <?
if($this->data['attrs']['show_author']):?>
    <div class="rn_PostAuthorImage">
        <img src="<?=$post->createdBy->avatar;?>" alt=""/>
    </div>
    <div class="rn_PostAuthor">
        <?printf($this->data['attrs']['label_author'],
$post->createdBy->name);?>
    </div>
    <?
endif;?>
    <div class="rn_Post">
        <span class="rn_PostTitle"><?=$post->title;?></span>
        <div class="rn_PostBody">
            <?=$post->fields[1]->value;?>
        </div>
        <?
if($this->data['attrs']['show_posted_date']):?>
            <span class="rn_PostDate rn_SubTitle"><? printf($this->data['attrs']['label_posted_date'], $post->created);?></span>
        <?
endif;?>
        <div class="rn_PostMeta">
            <div class="rn_PostRate">
            <?
$additionalPostRatingClass = ($post->ratingCount === 0) ? 'rn_NoRatings' : '';?>
            <?
if($post->userRating):?>
                <? ?>
                <span class="rn_PostRating <?=$additionalPostRatingClass;?>">
                    <span class="rn_UserRating <?=(($post->userRating->positive)?
'rn_PositiveRating' : 'rn_NegativeRating');?>"><?=$post->userRating->label;?></span>
            <?
else:?>
                <? if($this->data['attrs']['post_ratings']):?>
                    <? ?>
                    <span id="rn_<?=$this->instanceID;?>_PostRatingControls" class="rn_PostRatingControls">
                    <?
if(\RightNow\Utils\Framework::isLoggedIn()):?>
                        <? if(!$this->data['js']['newUser']):?>
                        <a class="rn_RateUp" id="rn_<?=$this->instanceID;?>_RateUp" href="javascript:void(0);"><?=$this->data['attrs']['label_positive_rating'];?></a>
                        <a class="rn_RateDown" id="rn_<?=$this->instanceID;?>_RateDown" href="javascript:void(0);"><?=$this->data['attrs']['label_negative_rating'];?></a>
                        <?
endif;?>
                    <?
else:?>
                        <a href="<?=$this->data['attrs']['login_link_url'];?>" class="rn_LoginRequiredLink"><?=$this->data['attrs']['label_login_link_rate'];?></a>
                    <?
endif;?>
                    </span>
                <?
endif;?>
                <span id="rn_<?=$this->instanceID;?>_PostRating" class="rn_PostRating <?=$additionalPostRatingClass;?>">
                    <span id="rn_<?=$this->instanceID;?>_UserRating" class="rn_UserRating"></span>
            <?
endif;?>
            <?
if($this->data['attrs']['show_post_ratings']):?>
                <? if($post->positiveRating):?>
                    <? $label = ($post->positiveRating === 1) ? $this->data['attrs']['label_single_rating_count'] : $this->data['attrs']['label_rating_count'];?>
                    <span class="rn_PositiveRating"><?
printf($label, $post->positiveRating);?></span>
                <?
endif;?>
                <?
if($post->negativeRating):?>
                    <? $label = ($post->negativeRating === 1) ? $this->data['attrs']['label_single_negative_rating_count'] : $this->data['attrs']['label_negative_rating_count'];?>
                    <span class="rn_NegativeRating"><?
printf($label, $post->negativeRating);?></span>           
                <?
endif;?>
            <?
endif;?>
                </span>
            </div>
        <?
if($this->data['attrs']['show_comment_count'] && $post->commentCount):?>
            <? $label = ($post->commentCount === 1) ? $this->data['attrs']['label_view_single_comment'] : $this->data['attrs']['label_view_comments'];?>
            <div class="rn_CommentCount" id="rn_<?=$this->instanceID;?>_CommentCount"><a id="rn_<?=$this->instanceID;?>_ShowComments" href="javascript:void(0);"><?
printf($label, $post->commentCount);?></a></div>
        <?
endif;?>
        <?
if($this->data['attrs']['post_comments']):?>
            <div class="rn_PostComment">
            <? if(\RightNow\Utils\Framework::isLoggedIn()):?>
                <? if($this->data['createAccountURL']):?>
                    <? if($this->data['attrs']['label_create_account']):?>
                    <strong><a href="<?=$this->data['createAccountURL'];?>"><?=$this->data['attrs']['label_create_account'];?></a></strong>
                    <?
endif;?>
                <?
else:?>
                <form onsubmit="return false;">
                    <textarea id="rn_<?=$this->instanceID;?>_Comment" rows="2" cols="20" class="rn_CommentPlaceHolder"><?=$this->data['attrs']['label_comment_placeholder']?></textarea>
                    <span id="rn_<?=$this->instanceID;?>_PostCommentSubmit" class="rn_Hidden">
                        <span class="rn_ScreenReaderOnly"><label for="rn_<?=$this->instanceID;?>_Comment"><?=\RightNow\Utils\Config::msgGetFrom((4695));?></label></span>
                        <input type="submit" value="<?=\RightNow\Utils\Config::msgGetFrom((4695));?>" id="rn_<?=$this->instanceID;?>_Submit"/>
                    </span>
                </form>
                <?
endif;?>
            <?
elseif($this->data['attrs']['label_login_link_comment']):?>
                <a href="<?=$this->data['attrs']['login_link_url'];?>" class="rn_LoginRequiredLink"><?=$this->data['attrs']['label_login_link_comment'];?></a>
            <?
endif;?>
            </div>
        <?
endif;?>
        </div>
    </div>
</div>
<?
}
function __construct($attrs){
parent::__construct($attrs);
$this->setAjaxHandlers(array( 'get_post_comments_ajax' => 'getPostComments', 'post_comment_ajax' => 'submitPostCommentAction', ));
}
function getData(){
if(!\RightNow\Utils\Config::getConfig((701))){
echo $this->reportError(\RightNow\Utils\Config::getMessage((3689)));
return false;
}
if(\RightNow\Utils\Config::getConfig((703)) === ''){
echo $this->reportError(\RightNow\Utils\Config::getMessage((3688)));
return false;
}
if($postHash = \RightNow\Utils\Url::getParameter('posts')){
$urlParameter = true;
}
else{
$postHash = $this->data['attrs']['post_hash'];
}
if(!$postHash){
return false;
}
$this->data['baseUrl'] = \RightNow\Utils\Config::getConfig((703));
$postObject = $this->CI->model('Social')->getCommunityPost($postHash)->result;
if(!$postObject || !$postObject->post){
echo \RightNow\Utils\Config::getMessage((2872));
return false;
}
else if($postObject->post->error && intval($postObject->post->error->code) === (35)){
$this->data['js']['newUser'] = true;
$this->data['createAccountURL'] = \RightNow\Utils\Config::getConfig((705)) . \RightNow\Utils\Url::communitySsoToken('?', true, \RightNow\Utils\Url::getShortEufBaseUrl('sameAsCurrentPage', \RightNow\Utils\Url::addParameter("/app/{$this->CI->page}",
'posts', $postHash) . \RightNow\Utils\Url::sessionParameter()));
}
$postObject->post->positiveRating = (int) ($postObject->post->ratingTotal / 100);
$postObject->post->negativeRating = (int) ($postObject->post->ratingCount - $postObject->post->positiveRating);
$this->data['js']['postRating'] = array('rating' => $postObject->post->ratingTotal, 'count' => $postObject->post->ratingCount);
if($postObject->post->ratedByRequestingUser && $postObject->post->ratedByRequestingUser->ratingValue !== null){
if($postObject->post->ratedByRequestingUser->ratingValue === 100){
$postObject->post->userRating = (object) array('label' => $this->data['attrs']['label_positive_rating_submitted'], 'positive' => true);
if($postObject->post->positiveRating === 1){
$postObject->post->positiveRating = 0;
}
}
else{
$postObject->post->userRating = (object) array('label' => $this->data['attrs']['label_negative_rating_submitted']);
if($postObject->post->negativeRating === 1){
$postObject->post->negativeRating = 0;
}
}
}
$this->data['post'] = $postObject->post;
$this->data['js']['postHash'] = $postHash;
if(!\RightNow\Utils\Framework::isLoggedIn() && $this->data['attrs']['login_link_url'] === '/app/' . \RightNow\Utils\Config::getConfig((229))){
$this->data['attrs']['login_link_url'] = \RightNow\Utils\Url::addParameter(\RightNow\Utils\Url::getShortEufBaseUrl('sameAsRequest', $this->data['attrs']['login_link_url'] . \RightNow\Utils\Url::sessionParameter()), 'redirect', urlencode($this->CI->page . (($urlParameter === true) ? "/posts/$postHash" : '')));
}
}
function getPostComments($parameters) {
\RightNow\Libraries\AbuseDetection::check();
\RightNow\Utils\Framework::sendCachedContentExpiresHeader();
echo json_encode($this->CI->model('Social')->getPostComments($parameters['postID'])->result);
}
function submitPostCommentAction($parameters) {
\RightNow\Libraries\AbuseDetection::check();
$response = $this->CI->model('Social')->performPostCommentAction($parameters['postID'], $parameters['action'], $parameters['content'], $parameters['commentID']);
$data = $response->result;
if($response->error){
$data['error'] = true;
$data['message'] = $response->error;
if($response->error->errorCode){
$data['errorCode'] = $response->error->errorCode;
}
}
echo json_encode($data);
}
}
function _standard_social_CommunityPostDisplay_header() {
$result = array( 'js_name' => 'RightNow.Widgets.CommunityPostDisplay', 'library_name' => 'CommunityPostDisplay', 'view_func_name' => '_standard_social_CommunityPostDisplay_view', 'meta' => array ( 'controller_path' => 'standard/social/CommunityPostDisplay', 'view_path' => 'standard/social/CommunityPostDisplay', 'js_path' => 'standard/social/CommunityPostDisplay', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/CommunityPostDisplay.css', 1 => 'assets/themes/mobile/widgetCss/CommunityPostDisplay.css', ), 'base_css' => array ( 0 => 'standard/social/CommunityPostDisplay/base.css', ), 'js_templates' => array ( 'comment' => '<img class=\'rn_Avatar\' src=\'<%= avatar %>\' alt=\'\'/><span class=\'rn_Commenter\'><%= commenter %></span><span class=\'rn_CommentText\'><%= comment %></span><% if (showPostedDate) { %><span class=\'rn_CommentDate rn_SubTitle\'><%= RightNow.Text.sprintf(postedDate, commentCreated) %></span><% } %><% if (displayRatingControls) { %><span id=\'rn_<%= instanceID %>_RatingControls<%= commentID %>\' class=\'rn_CommentRatingControls\'>  <a class=\'rn_Rate rn_RateUp\' href=\'javascript:void(0);\' name=\'rateUp<%= commentID %>\'><%= positiveRating %></a>   <a class=\'rn_Rate rn_RateDown\' href=\'javascript:void(0);\' name=\'rateDown<%= commentID %>\'><%= negativeRating %></a> </span><% } %><span class=\'rn_CommentRating\' id=\'rn_<%= instanceID %>_Rating<%= commentID %>\'><%= ratingSection %></span>', 'rating' => '<% if (displayUserRating) { %><span class=\'rn_UserRating <%= userClassRating %>\'><%= userRatingLabel %></span><% } %><% if (displayPositiveRating) { %><span class=\'rn_PositiveRating\'><%= positiveRatingLabel %></span><% } %><% if (displayNegativeRating) { %><span class=\'rn_NegativeRating\'><%= negativeRatingLabel %></span><% } %>', ), 'template_path' => 'standard/social/CommunityPostDisplay', 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', ), 'jsModule' => array ( 0 => 'standard', 1 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4260)', 'urlParameters' => array ( 'posts' => array ( 'name' => 'rn:msg:(3223)', 'description' => 'rn:msg:(3219)', 'example' => 'posts/88af22078d', ), ), ), 'relativePath' => 'standard/social/CommunityPostDisplay', 'widget_name' => 'CommunityPostDisplay', ), );
$result['meta']['attributes'] = array( 'get_post_comments_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajax/widget', 'type' => 'AJAX', 'default' => '/ci/ajax/widget', 'inherited' => false, )), 'post_comment_ajax' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/ci/ajax/widget', 'type' => 'AJAX', 'default' => '/ci/ajax/widget', 'inherited' => false, )), 'show_posted_date' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'show_author' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'post_comments' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'post_ratings' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'show_comment_count' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'show_post_ratings' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => true, 'type' => 'BOOLEAN', 'default' => true, 'inherited' => false, )), 'login_link_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/' . \RightNow\Utils\Config::getConfig((229)), 'type' => 'STRING', 'default' => '/app/' . \RightNow\Utils\Config::getConfig((229)), 'inherited' => false, )), 'post_hash' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'label_author' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1051), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1051), 'inherited' => false, )), 'label_posted_date' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '%s', 'type' => 'STRING', 'default' => '%s', 'inherited' => false, )), 'label_view_comments' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4149), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4149), 'inherited' => false, )), 'label_view_single_comment' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4148), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4148), 'inherited' => false, )), 'label_rating_count' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2985), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2985), 'inherited' => false, )), 'label_negative_rating_count' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2983), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2983), 'inherited' => false, )), 'label_single_rating_count' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2987), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2987), 'inherited' => false, )), 'label_single_negative_rating_count' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2986), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2986), 'inherited' => false, )), 'label_positive_rating' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(7660), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(7660), 'inherited' => false, )), 'label_negative_rating' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1616), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1616), 'inherited' => false, )), 'label_positive_rating_submitted' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4426), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4426), 'inherited' => false, )), 'label_negative_rating_submitted' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4414), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4414), 'inherited' => false, )), 'label_comment_placeholder' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4400), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4400), 'inherited' => false, )), 'label_login_link_rate' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2614), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2614), 'inherited' => false, )), 'label_login_link_comment' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(2608), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(2608), 'inherited' => false, )), 'label_create_account' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1416), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1416), 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class MobileNavigationMenu extends \RightNow\Libraries\Widget\Base {
function _standard_navigation_MobileNavigationMenu_view ($data) {
extract($data);
?><?php ?>
<span id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
<button type="button" id="rn_<?=$this->instanceID;?>_Link"><?=$this->data['attrs']['label_button'];?></button>
</span>
<?
}
}
function _standard_navigation_MobileNavigationMenu_header() {
$result = array( 'js_name' => 'RightNow.Widgets.MobileNavigationMenu', 'library_name' => 'MobileNavigationMenu', 'view_func_name' => '_standard_navigation_MobileNavigationMenu_view', 'meta' => array ( 'controller_path' => 'standard/navigation/MobileNavigationMenu', 'view_path' => 'standard/navigation/MobileNavigationMenu', 'js_path' => 'standard/navigation/MobileNavigationMenu', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/MobileNavigationMenu.css', ), 'base_css' => array ( 0 => 'standard/navigation/MobileNavigationMenu/base.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4255)', ), 'relativePath' => 'standard/navigation/MobileNavigationMenu', 'widget_name' => 'MobileNavigationMenu', ), );
$result['meta']['attributes'] = array( 'label_button' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(7520), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(7520), 'inherited' => false, )), 'label_parent_menu_alt' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(29091), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(29091), 'inherited' => false, )), 'submenu' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), 'css_class' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'rn_Selected', 'type' => 'STRING', 'default' => 'rn_Selected', 'inherited' => false, )), );
return $result;
}
}
namespace RightNow\Widgets{
class MobileSimpleSearch extends \RightNow\Libraries\Widget\Base {
function _standard_search_MobileSimpleSearch_view ($data) {
extract($data);
?><?php ?>
<div id="rn_<?=$this->instanceID;?>" class="<?=$this->classList
?>">
    <form id="rn_<?=$this->instanceID;?>_SearchForm" onsubmit="return false;">
        <label for="rn_<?=$this->instanceID;?>_SearchField" class="rn_ScreenReaderOnly"><?=$this->data['attrs']['label_hint'];?></label>
        <input type="text" id="rn_<?=$this->instanceID;?>_SearchField" name="rn_<?=$this->instanceID;?>_SearchField" class="<?=$this->data['cssClass'];?>" maxlength="255" value="<?=$this->data['attrs']['label_hint'];?>"/>
        <?
if ($this->data['attrs']['clear_text_icon_path']): ?>
        <div id="rn_<?=$this->instanceID;?>_Clear" role="button" aria-label="<?=$this->data['attrs']['label_clear_text_icon'];?>" class="rn_ClearText rn_Hidden"><img src="<?=$this->data['attrs']['clear_text_icon_path'];?>" alt=""/></div>
        <?
endif;
?>
        <? if ($this->data['attrs']['search_icon_path']): ?>
        <input type="image" id="rn_<?=$this->instanceID;?>_Submit" class="rn_SearchImage" src="<?=$this->data['attrs']['search_icon_path'];?>" alt="<?=$this->data['attrs']['label_search'];?>"/>
        <?
else: ?>
        <input type="submit" id="rn_<?=$this->instanceID;?>_Submit" class="rn_SearchButton" value="<?=$this->data['attrs']['label_search'];?>"/>
        <?
endif;?>
    </form>
</div>
<?
}
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
if($this->data['attrs']['report_page_url'] === '') $this->data['attrs']['report_page_url'] = '/app/' . $this->CI->page;
$this->data['cssClass'] = (($this->data['attrs']['clear_text_icon_path']) ? 'rn_RightPadding' : '') . (($this->data['attrs']['search_icon_path']) ? ' rn_LeftPadding' : '');
}
}
function _standard_search_MobileSimpleSearch_header() {
$result = array( 'js_name' => 'RightNow.Widgets.MobileSimpleSearch', 'library_name' => 'MobileSimpleSearch', 'view_func_name' => '_standard_search_MobileSimpleSearch_view', 'meta' => array ( 'controller_path' => 'standard/search/MobileSimpleSearch', 'view_path' => 'standard/search/MobileSimpleSearch', 'js_path' => 'standard/search/MobileSimpleSearch', 'presentation_css' => array ( 0 => 'assets/themes/mobile/widgetCss/MobileSimpleSearch.css', ), 'version' => '1.0.1', 'requires' => array ( 'framework' => array ( 0 => '3.0', 1 => '3.1', 2 => '3.2', ), 'jsModule' => array ( 0 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4367)', ), 'relativePath' => 'standard/search/MobileSimpleSearch', 'widget_name' => 'MobileSimpleSearch', ), );
$result['meta']['attributes'] = array( 'report_page_url' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '/app/answers/list', 'type' => 'STRING', 'default' => '/app/answers/list', 'inherited' => false, )), 'search_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'filepath', 'default' => '', 'inherited' => false, )), 'clear_text_icon_path' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 'images/x.png', 'type' => 'filepath', 'default' => 'images/x.png', 'inherited' => false, )), 'label_clear_text_icon' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(1188), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(1188), 'inherited' => false, )), 'label_search' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4693), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4693), 'inherited' => false, )), 'label_hint' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => '', 'type' => 'STRING', 'default' => '', 'inherited' => false, )), );
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
$result = array( 'js_name' => '', 'library_name' => 'PageSetSelector', 'view_func_name' => '_standard_utils_PageSetSelector_view', 'meta' => array ( 'controller_path' => 'standard/utils/PageSetSelector', 'view_path' => 'standard/utils/PageSetSelector', 'presentation_css' => array ( 0 => 'assets/themes/standard/widgetCss/PageSetSelector.css', 1 => 'assets/themes/basic/widgetCss/PageSetSelector.css', 2 => 'assets/themes/mobile/widgetCss/PageSetSelector.css', ), 'version' => '1.1.1', 'requires' => array ( 'framework' => array ( 0 => '3.1', 1 => '3.2', 2 => '3.3', ), 'jsModule' => array ( 0 => 'none', 1 => 'standard', 2 => 'mobile', ), ), 'info' => array ( 'description' => 'rn:msg:(4224)', ), 'relativePath' => 'standard/utils/PageSetSelector', 'widget_name' => 'PageSetSelector', ), );
$result['meta']['attributes'] = array( 'cookie_expiration' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => 10, 'type' => 'INT', 'default' => 10, 'inherited' => false, )), 'label_message' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => \RightNow\Utils\Config::getMessage(4157), 'type' => 'STRING', 'default' => \RightNow\Utils\Config::getMessage(4157), 'inherited' => false, )), 'page_sets' => \RightNow\Libraries\Widget\Attribute::__set_state(array( 'value' => sprintf('default > %s, mobile > %s, basic > %s', \RightNow\Utils\Config::getMessage((1572)), \RightNow\Utils\Config::getMessage((4880)), \RightNow\Utils\Config::getMessage((43115))), 'type' => 'STRING', 'default' => sprintf('default > %s, mobile > %s, basic > %s', \RightNow\Utils\Config::getMessage((1572)), \RightNow\Utils\Config::getMessage((4880)), \RightNow\Utils\Config::getMessage((43115))), 'inherited' => false, )), );
return $result;
}
}
namespace{
use \RightNow\Utils\FileSystem;
?>
<!DOCTYPE html>
<html lang="<?=\RightNow\Utils\Text::getLanguageCode();?>">
    <head>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0; user-scalable=no;"/>
        <meta charset="utf-8"/>
        <title><?=\RightNow\Utils\Tags::getPageTitleAtRuntime();?></title>
        <?=
\RightNow\Libraries\SEO::getCanonicalLinkTag() . "\n";
?>
<style type='text/css'>
 <!-- 
.rn_ScreenReaderOnly{position:absolute; height:1px; left:-10000px; overflow:hidden; top:auto; width:1px;}
.rn_Hidden{display:none;}
 --></style>
<base href='<?=\RightNow\Utils\Url::getShortEufBaseUrl('sameAsRequest', \RightNow\Utils\FileSystem::getOptimizedAssetsDir() . 'themes/mobile/');?>'/>
<link href='<?=FileSystem::getOptimizedAssetsDir();?>templates/mobile.themes.mobile.SITE.css' rel='stylesheet' type='text/css' media='all'/>
<style type="text/css">
<!--
.rn_MobileNavigationMenu button{padding:6px 10px;width:auto;}
.rn_MobileNavigationMenu.rn_Menu li a .rn_ParentMenuAlt{opacity:0;position:absolute;left:0;}
.rn_MobileNavigationMenu button{background:#597EAA;background: -moz-linear-gradient(top, rgba(154, 175, 202, 1.0), rgba(89, 126, 170, 1.0), rgba(90, 127, 171, 1.0));background: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(0.0, rgba(154, 175, 202, 1.0)), color-stop(0.5, rgba(89, 126, 170, 1.0)), color-stop(1.0, rgba(90, 127, 171, 1.0)));border:1px solid #AAA;border-color:#444 #999 #DDD;color:#FFF;display:block;font-size:inherit;font-weight:bold;margin-top:5px;text-shadow:1px 1px 3px rgba(0, 0, 0, .5);-moz-border-radius:6px;-moz-box-shadow:0 0 0 rgba(0, 0, 0, .5);-webkit-box-shadow:0 0 0 rgba(0, 0, 0, .5);-webkit-border-radius:6px;}
.rn_MobileNavigationMenu button.rn_Selected{background:#38547B;background: -moz-linear-gradient(top, #7084A0 0%, #39567F 50%, #364F70 100%);background: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(0.0, #7084A0), color-stop(0.5, #39567F), color-stop(1.0, #364F70));}
.rn_MobileNavigationMenu.rn_Menu{padding:20px 0 0;}
.rn_MobileNavigationMenu.rn_Menu li a{border-bottom:1px solid #DDD;color:#FFF;display:block;font-size:1.5em;font-weight:bold;padding:26px 16px;line-height:1.15em;}
.rn_MobileNavigationMenu.rn_Menu li a.rn_ParentMenu{background:transparent url(<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile/images/layout/whiteListArrow.png) no-repeat right;}
.rn_MobileSimpleSearch{margin:auto;width:80%;}
.rn_MobileSimpleSearch form{position:relative;}
.rn_MobileSimpleSearch .rn_ClearText{height:30px;padding:8px 0 0 8px;position:absolute;right:0;top:0;width:30px;z-index:100;}
.rn_MobileSimpleSearch input[type="submit"]{font-size:1.7em;}
.rn_MobileSimpleSearch input[type="text"]{margin-bottom:12px;}
.rn_MobileSimpleSearch input[type="text"].rn_LeftPadding{padding-left:10%;width:89%;}
.rn_MobileSimpleSearch input[type="text"].rn_RightPadding{padding-right:10%;width:89%;}
.rn_MobileSimpleSearch input[type="text"].rn_LeftPadding.rn_RightPadding{width:79%;}
.rn_MobileSimpleSearch input[type="image"]{border:none;padding:10px 0 10px 2.5%;position:absolute;left:0;top:0;z-index:100;}
.rn_PageSetSelector{display:block;margin-bottom:16px;}
.rn_CommunityPostDisplay p{line-height: normal;margin-bottom: 0;}
.rn_CommunityPostDisplay .rn_CommentText, .rn_CommunityPostDisplay input[type="button"]{display: block;}
.rn_CommunityPostDisplay{background:#fff;position:relative;padding:10px;color: #333;font-size: 1em;line-height: 1.1em;}
.rn_CommunityPostDisplay .rn_PostAuthorImage{position:absolute;top:10px;left:10px;width:50px;height:50px;}
.rn_CommunityPostDisplay .rn_PostAuthorImage img{height:100%;width:100%;}
.rn_CommunityPostDisplay .rn_PostAuthor{padding:0 0 0 60px;margin-bottom: 5px;font-weight:bold;color:#666;}
.rn_CommunityPostDisplay .rn_PostTitle{font-size:1.3em;line-height:1.05em;display:block;margin-bottom: 5px;color:#666;}
.rn_CommunityPostDisplay .rn_PostBody p{margin:0 0 12px 0;}
.rn_CommunityPostDisplay .rn_PostBody img{max-width:95%;height:auto;margin:0 2%;}
.rn_CommunityPostDisplay .rn_PostBody{overflow:hidden;}
.rn_CommunityPostDisplay .rn_PostDate{display:block;margin:0 0 5px 0;color:#acacac;}
.rn_CommunityPostDisplay .rn_PostTitle{display:block;padding:0 0 0 60px;}
.rn_CommunityPostDisplay .rn_PostBody{display:block;padding:0 0 0 60px;}
.rn_CommunityPostDisplay .rn_PostDate{display:block;padding:0 0 0 60px;color: #666;font-size: 0.8em;}
.rn_CommunityPostDisplay .rn_CommentCount{display:block;padding:5px 0 5px 60px;text-align:right;border-bottom: 1px solid #DDD;}
.rn_CommunityPostDisplay .rn_CommentCount a{line-height: 22px;background:url(<?=FileSystem::getOptimizedAssetsDir();?>themes/mobile/images/searchList-more-arrow.png) right 1px no-repeat;background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAWCAYAAAAfD8YZAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBNYWNpbnRvc2giIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MDk4RTY1MjM5QjgxMTFFMEJBM0E4MjAwQzUwNTExQ0UiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MDk4RTY1MjQ5QjgxMTFFMEJBM0E4MjAwQzUwNTExQ0UiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDoyNjE4REM3NDlCN0ExMUUwQkEzQTgyMDBDNTA1MTFDRSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDowOThFNjUyMjlCODExMUUwQkEzQTgyMDBDNTA1MTFDRSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PluDGtwAAAFNSURBVHjalNS7SgNREMbxGO8KCkJ8AIk3XMXOV7BXUbwh9iLYWmynoGBnoZWt4I1oZxMv+AAWFpJChYiLiCKCrf+BCRyWOSdx4AdJJt/umXM2qYvjOONUO3J4ytRQWed1J/Zxieg/4S7sYRZ5HGGwlnAHDjDtfN6PEwxVCzeixegN6AVGQuEPzOHC6PfpCFFo5ncs4dz4Ti+OrRHc3ZYVzHsuICs4xbAvLPWNRRQ8K5A9GPWFpb6wrHdKV15HiHzhygiygkOj14Mz2YNs4Bh/UPL0PmWFvrCc/QbWjd4dJlBuMJpN2MSa0bvBAl7kTTpcjy2seoIzeK184IabsY0VI3iLKSTWObdhxxO81sc3STfkzq3Y1cczXUV96srWrkq4G2NG70pnTEK/qmdM4jF1x2DQnflBN6SkM8pS36r9k7i7fY9x/LrHEao/AQYAT9E+Xxk6CH8AAAAASUVORK5CYII=) right 1px no-repeat;padding-right:20px;height: 22px;font-size: 1.2em;display:inline-block;margin-bottom:10px;}
.rn_CommunityPostDisplay .rn_LoadedComments .rn_Comment:nth-child(even){background:#f6f6f6;}
.rn_CommunityPostDisplay .rn_Comment{position:relative;padding-bottom:10px;padding-top:10px;border-bottom:1px solid #DDD;}
.rn_CommunityPostDisplay .rn_Comment .rn_Avatar{position:absolute;top:10px;left:10px;width:40px;height:40px;}
.rn_CommunityPostDisplay .rn_Commenter{display:block;padding:0 0 0 60px;font-weight:bold;margin:0 0 5px 0;color:#666;}
.rn_CommunityPostDisplay .rn_CommentText{display:block;padding:0 0 0 60px;margin:0 0 5px 0;}
.rn_CommunityPostDisplay .rn_CommentDate{display:block;padding:0 0 0 60px;color: #666;font-size: 0.8em;}
.rn_CommunityPostDisplay .rn_CommentRating{display:block;padding:0 0 0 60px;}
.rn_CommunityPostDisplay .rn_PostRate{display:block;padding:0 0 0 60px;}
-->
</style>
9c1379bc-cca6-4750-aee7-188f8348a6c3
        <link rel="icon" href="images/favicon.png" type="image/png">
    </head>
    <body>
        <noscript><h1><?=\RightNow\Utils\Config::msgGetFrom((4861));?></h1></noscript>
        <header role="banner">
            <?if(
(true) ):?>
            <nav id="rn_Navigation" role="navigation">
                <span class="rn_FloatLeft">
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/navigation/MobileNavigationMenu', array('submenu' => 'rn_MenuList',));
?>
                </span>
                <ul id="rn_MenuList" class="rn_Hidden">
                    <li>
                        <a href="/app/home<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2097));?></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="rn_ParentMenu"><?=\RightNow\Utils\Config::msgGetFrom((1340));?></a>
                        <ul class="rn_Submenu rn_Hidden">
                            <li><a href="/app/chat/chat_launch<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((7494));?></a></li>
                            <li><a href="/app/ask<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((1748));?></a></li>
                            <li><a href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((1109));?></a></li>
                            <li><a href="javascript:void(0);"><?=\RightNow\Utils\Config::msgGetFrom((1025));?></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="rn_ParentMenu"><?=\RightNow\Utils\Config::msgGetFrom((4436));?></a>
                        <ul class="rn_Submenu rn_Hidden">
                            <?if(
(!\RightNow\Utils\Framework::isLoggedIn()) ):?>
                            <li><a href="/app/utils/create_account<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((3650));?></a></li>
                            <li><a href="/app/utils/login_form<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2601));?></a></li>
                            <li><a href="/app/utils/account_assistance<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((901));?></a></li>
                            <?endif;?>
                            <li><a href="/app/account/questions/list<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((4163));?></a></li>
                            <li><a href="/app/account/profile<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((1135));?></a></li>
                        </ul>
                    </li>
                </ul>
                <span class="rn_FloatRight rn_Search" role="search">
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/navigation/MobileNavigationMenu',
array('label_button' => '' . \RightNow\Utils\Config::msgGetFrom((6920)) . '<img src=\'images/search.png\' alt=\'' . \RightNow\Utils\Config::msgGetFrom((6920)) . '\'/>','submenu' => 'rn_SearchForm',));
?>
                </span>
                <div id="rn_SearchForm" class="rn_Hidden">
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/search/MobileSimpleSearch', array('report_page_url' => '/app/answers/list',));
?>
                </div>
            </nav>
            <?endif;?>
        </header>
        <section role="main">
<div class="section rn_PostDetail">
    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/social/CommunityPostDisplay',
array());
?>
</div>
        </section>
        <footer role="contentinfo">
            <?if( (true) ):?>
                <div>
                    <?if( (\RightNow\Utils\Framework::isLoggedIn()) ):?>
                    <?=\RightNow\Utils\Connect::getFormattedObjectFieldValue(array ( 0 => 'Contact', 1 => 'Emails', 2 => 'PRIMARY', 3 => 'Address', ), false);?><?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/login/LogoutLink',
array());
?>
                    <?else:?>
                    <a href="/app/utils/login_form<?=\RightNow\Utils\Url::sessionParameter();?>"><?=\RightNow\Utils\Config::msgGetFrom((2601));?></a>
                    <?endif;?>
                    <br/><br/>
                </div>
                <?if(
((get_instance()->page !== 'utils/guided_assistant') ) ):?>
                    <?=\RightNow\Utils\Widgets::rnWidgetRenderCall('standard/utils/PageSetSelector', array());
?>
                <?endif;?>
                <div class="rn_FloatLeft"><a href="javascript:window.scrollTo(0, 0);"><?=\RightNow\Utils\Config::msgGetFrom((1018));?></a></div>
            <?endif;?>
            <div class="rn_FloatRight">Powered by <a href="http://www.rightnow.com">RightNow</a></div>
            <br/><br/>
        </footer>
<?=get_instance()->clientLoader->getYuiConfiguration();?><script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>templates<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/login/LogoutLink', 1 => 'standard/navigation/MobileNavigationMenu', 2 => 'standard/search/MobileSimpleSearch', ), '/mobile.js', '1495130941');?>"></script>
<script type="text/javascript" src="<?=FileSystem::getOptimizedAssetsDir();?>pages<?=\RightNow\Utils\Framework::calculateJavaScriptHash(array
( 0 => 'standard/social/CommunityPostDisplay', ), '/mobile/social/post_detail.js', '1495130941');?>"></script>
<?get_instance()->clientLoader->convertWidgetInterfaceCalls(array
( 'WARNING_LBL' => array ( 'value' => 6789, ), 'INFORMATION_LBL' => array ( 'value' => 29487, ), 'HELP_LBL' => array ( 'value' => 9808, ), 'ERROR_REQUEST_ACTION_COMPLETED_MSG' => array ( 'value' => 1809, ), 'OK_LBL' => array ( 'value' => 864, ), 'DIALOG_LBL' => array ( 'value' => 1603, ), 'DIALOG_PLEASE_READ_TEXT_DIALOG_MSG_MSG' => array ( 'value' => 1604, ), 'BEG_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1087, ), 'END_DIALOG_PLS_DISMISS_DIALOG_BEF_MSG' => array ( 'value' => 1767, ), 'ERR_SUBMITTING_FORM_DUE_INV_INPUT_LBL' => array ( 'value' => 1842, ), 'ERR_SUBMITTING_SEARCH_MSG' => array ( 'value' => 3399, ), 'CLOSE_CMD' => array ( 'value' => 850, ), 'BACK_LBL' => array ( 'value' => 14017, ), 'NEW_CONTENT_ADDED_BELOW_MSG' => array ( 'value' => 2802, ), 'YOUR_COMMENT_WAS_ADDED_LBL' => array ( 'value' => 24205, ), ), array ( 'DE_VALID_EMAIL_PATTERN' => array ( 'value' => 192, ), 'CP_HOME_URL' => array ( 'value' => 226, ), 'CP_FILE_UPLOAD_MAX_TIME' => array ( 'value' => 202, ), 'OE_WEB_SERVER' => array ( 'value' => 9, ), ));?>
<?=get_instance()->clientLoader->getClientInitializer();?><?=get_instance()->clientLoader->getAdditionalJavaScriptReferences();?>
<?=\RightNow\Utils\Text::getRandomStringOnHttpsLogin();?>
</body>
</html>
<?
}
?>
