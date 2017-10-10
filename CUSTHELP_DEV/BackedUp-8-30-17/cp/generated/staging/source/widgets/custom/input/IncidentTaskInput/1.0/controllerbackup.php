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
        $this->data['results'] = array();
        $seq=1;
        while($record = $result->next()) {
            
            $this->data['results'][$seq]=$record;
            $seq++;
       }
 */
                $this->data['attrs']['data_type'] = 'products';  strtolower($this->data['attrs']['data_type']);
        // $this->data['results'] = $this->CI->model('Prodcat')->getHierarchy($this->data['attrs']['data_type'], $this->data['attrs']['levels'], $this->data['attrs']['maximum_top_levels'])->result;
        
       
        if($this->data['attrs']['add_params_to_url'])
            $this->data['appendedParameters'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']);


        $all_levels = $this->CI->model('Prodcat')->getHierPopup($this->data['attrs']['data_type'])->result;
        $this->data['results'] = array();
        $seq = 1; 
      
         //print_r($all_levels);
        foreach($all_levels as $value) {
            // print_r($value);
            // print("<a href=\"https://emersonnetworkpower.custhelp.com/app/answers/list/p/" . $value['hier_list'] . "\"><$h>" . $value[0] . "</$h></a><br /><br />"); 
            switch($value['level']) {
                case 0 :
                    $id1 = $value[1];
                    $parent = $value[3];
                    $this->data['results'][$id1] = array('id'=>$id1, 'label'=>$value[0], $seq++, 'parent'=>$parent, 'level'=>$value['level'], 'hierList'=>$value[hier_list]);
                    break;
                case 1 :
                    $id2 = $value[1];
                    $parent = $value[3];
                    $this->data['results'][$id1]['subItems'][$id2] = array('id'=>$id2, 'label'=>$value[0], $seq++, 'parent'=>$parent, 'level'=>$value['level'], 'hierList'=>$value[hier_list]);
                    break;
                case 2 :
                    $id3 = $value[1];
                    $parent = $value[4];
                    $this->data['results'][$id1]['subItems'][$id2]['subItems'][$id3] = array('id'=>$id3, 'label'=>$value[0], $seq++, 'parent'=>$parent, 'level'=>$value['level'], 'hierList'=>$value[hier_list]);
                    break;
            }
        }
    }
    /**
     * Handles the default_ajax_endpoint AJAX request
     * @param array $params Get / Post parameters
     */
        function handle_getProducts_ajax_endpoint($params) {
        // Perform AJAX-handling here...
          $result = Connect\ROQL::query("select Id, Name from ServiceProduct s where parent=28 " )->next();
          echo "<select id=\"products\">";
          while($record = $result->next()) {
               echo " <option value=\"$record[ID]\">$record[Name]</option>";
            }
         echo "</select> ";        // echo response
    }
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