<?php
namespace Custom\Widgets\input;
use RightNow\Api,
	RightNow\Connect\v1_2 as Connect;

class IncidentTaskInput extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);

        $this->setAjaxHandlers(array(
            'saveTaskData_ajax_endpoint' => array(
                'method'      => 'handle_saveTaskData_ajax_endpoint',
                'clickstream' => 'custom_action',
            ),
        ));
    }

    function getData() {

        //return parent::getData();
/*        $result = Connect\ROQL::query("select Id, Name from ServiceProduct s where parent=915 " )->next();
        $this->data['js']['results'] = array();
        $seq=1;
        while($record = $result->next()) {
            
            $this->data['js']['results'][$seq]=$record;
            $seq++;
       }
 */
        //$this->data = parent::getData();
        $all_levels = $this->CI->model('Prodcat')->getHierPopup("products")->result;
        $this->data['js']['results'] = array();
        $seq = 1; 
      
         //print_r($all_levels);
        foreach($all_levels as $value) {
            // print_r($value);          
                $id1 = $value[1];
                $parent = $value[3];
                $this->data['js']['results'][$id1] = array('id'=>$id1, 'label'=>$value[0], $seq++, 'parent'=>$parent, 'level'=>$value['level'], 'hierList'=>$value[hier_list]);
        }
    }
    /**
     * Handles the default_ajax_endpoint AJAX request
     * @param array $params Get / Post parameters
     */
    function handle_saveTaskData_ajax_endpoint($params) {
            // Perform AJAX-handling here...
          // echo response
          if (isset($params)) {
         // logMessage($params['topics']);
          $mySession['topics'] = $params['topics'];
          $CI =& get_instance();
          // session id is getting changed in post incident create so using setcookie
          $CI->session->setSessionData($mySession);
            setcookie('TOPICS', $params['topics'],0,'/');
          
      //    logMessage($CI->session->getSessionData('sessionID'));
      //    logMessage($CI->session->getSessionData('topics'));
         } else {
             logMessage("hi");
          }
          echo json_encode(array('result'=>array('status'=>1)));
      //echo  $params;
    }    
}
?>