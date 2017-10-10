<?php
namespace Custom\Widgets\input;
use RightNow\Api,
	RightNow\Connect\v1_2 as Connect;

class IncidentTaskInput extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);

        $this->setAjaxHandlers(array(
            'getProducts_ajax_endpoint' => array(
                'method'      => 'handle_getProducts_ajax_endpoint',
                'clickstream' => 'custom_action',
            ),
            'saveTaskData_ajax_endpoint' => array(
                'method'      => 'handle_saveTaskData_ajax_endpoint',
                'clickstream' => 'custom_action',
            ),
        ));
    }

    function getData() {

        //return parent::getData();
        $result = Connect\ROQL::query("select Id, Name from ServiceProduct s where parent=915 " )->next();
        $this->data['results'] = array();
        $seq=1;
        while($record = $result->next()) {
            
            $this->data['results'][$seq]=$record;
            $seq++;
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
    }    

Public function getProducts_DropDown($mybaseId) {

}
}
?>