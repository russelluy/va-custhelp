<?php
 class ajaxCustom extends ControllerBase {
function __construct() {
parent::__construct();
}
function ajaxFunctionHandler() {
$postData = $this->input->post('post_data_name');
echo $returnedInformation;
}
}
