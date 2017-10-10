<?php
namespace Custom\Models;
use RightNow\Api, RightNow\Connect\v1_2 as Connect;
class hooks_model extends \RightNow\Models\Base {
function __construct() {
parent::__construct();
}
function jsptest() {
$CI =&get_instance();
$mySession = $CI->session->getSessionData('topics');
print_r($mySession);
echo "490598";
$inc = Connect\incident::fetch( 490598 );
$tasks = json_decode($mySession);
if (is_array($tasks)) {
foreach($tasks as $key => $value) {
$experience = $value->experience;
$topicId= $value->id;
try{
$new_task=new Connect\Task();
$new_task->Name= $experience;
$notes='';
for( $i=0;
$i < count($inc->Threads);
$i++) {
if ($inc->Threads[$i]->EntryType->ID ===3) {
$notes.= $inc->Threads[$i]->Text;
}
}
if (strlen($notes)>4000) {
$notes= substr($notes, 0, 4000);
}
$new_task->Comment = $notes;
$new_task->PercentComplete=0;
$new_task->Priority= new Connect\NamedIDOptList();
$new_task->Priority->ID=1;
$new_task->ServiceSettings=new Connect\TaskServiceSettings();
$new_task->ServiceSettings->Incident=$inc;
$new_task->StatusWithType = new Connect\StatusWithType();
$new_task->StatusWithType->Status->ID = 16;
$new_task->TaskType=new Connect\NamedIDOptList();
$new_task->TaskType->ID=1;
$md = $new_task::getMetadata();
$cf_type_name = $md->CustomFields->type_name;
$md2 = $cf_type_name::getMetadata();
$new_task->CustomFields->c = new $md2->c->type_name;
$new_task->CustomFields->c->reason = new Connect\NamedIDLabel();
$new_task->CustomFields->c->reason->LookupName = "Idea/Suggestion";
$new_task->CustomFields->Integration = new $md2->Integration->type_name;
$new_task->CustomFields->Integration->TaskProduct = new Connect\ServiceProduct;
$new_task->CustomFields->Integration->TaskProduct = Connect\ServiceProduct::fetch( $topicId );
$new_task->save();
echo $new_task->ID;
echo $new_task->Name;
echo "<br> product id:";
echo $new_task->CustomFields->Integration->TaskProduct.ID;
}
catch (Exception $err ){
echo $err->getMessage();
}
}
}
}
function pre_incident_create($hookData) {
}
function post_incident_create($hookData) {
$incdata = $hookData['data'];
$CI =get_instance();
$mySession =$this->CI->session->getSessionData('topics');
$inc = Connect\incident::fetch($incdata->ID );
$tasks = json_decode($mySession);
if (is_array($tasks)) {
foreach($tasks as $key => $value) {
$experience = $value->experience;
$topicId= $value->id;
try{
$new_task=new Connect\Task();
$new_task->Name= $experience;
$notes='';
for( $i=0;
$i < count($inc->Threads);
$i++) {
if ($inc->Threads[$i]->EntryType->ID ===3) {
$notes.= $inc->Threads[$i]->Text;
}
}
if (strlen($notes)>4000) {
$notes= substr($notes, 0, 4000);
}
$new_task->Comment = $notes;
$new_task->PercentComplete=0;
$new_task->Priority= new Connect\NamedIDOptList();
$new_task->Priority->ID=1;
$new_task->ServiceSettings=new Connect\TaskServiceSettings();
$new_task->ServiceSettings->Incident=$inc;
$new_task->StatusWithType = new Connect\StatusWithType();
$new_task->StatusWithType->Status->ID = 16;
$new_task->TaskType=new Connect\NamedIDOptList();
$new_task->TaskType->ID=1;
$md = $new_task::getMetadata();
$cf_type_name = $md->CustomFields->type_name;
$md2 = $cf_type_name::getMetadata();
$new_task->CustomFields->c = new $md2->c->type_name;
$new_task->CustomFields->c->reason = new Connect\NamedIDLabel();
$new_task->CustomFields->c->reason->LookupName = "Idea/Suggestion";
$new_task->CustomFields->Integration = new $md2->Integration->type_name;
$new_task->CustomFields->Integration->TaskProduct = new Connect\ServiceProduct;
$new_task->CustomFields->Integration->TaskProduct = Connect\ServiceProduct::fetch( $topicId );
$new_task->save();
}
catch (Exception $err ){
echo $err->getMessage();
}
}
}
}
}