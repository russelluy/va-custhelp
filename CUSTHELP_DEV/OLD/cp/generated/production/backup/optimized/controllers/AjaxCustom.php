<?php
 namespace Custom\Controllers;
class AjaxCustom extends \RightNow\Controllers\Base {
function __construct() {
parent::__construct();
}
function ajaxFunctionHandler() {
$postData = $this->input->post('post_data_name');
echo $returnedInformation;
}
}
