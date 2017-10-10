<?php
namespace Custom\Models;
class ExtendedSample extends \RightNow\Models\Answer {
function __construct() {
parent::__construct();
}
function emailToFriend($sendTo, $name, $from, $answerID){
$name .= "(Email: $from)";
$from = "support@companyName.com";
$response = parent::emailToFriend($sendTo, $name, $from, $answerID);
if($response->result){
return $response;
}
$response->error = "Unable to send email, please try again later.";
return $response;
}
}
