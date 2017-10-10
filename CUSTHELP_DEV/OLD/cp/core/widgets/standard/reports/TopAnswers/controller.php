<?php /* Originating Release: November 2014 */

namespace RightNow\Widgets;

class TopAnswers extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs){
        parent::__construct($attrs);
    }

    function getData(){
        $answerContent = $this->CI->model('Answer')->getPopular($this->data['attrs']['limit'], $this->data['attrs']['product_filter_id'], $this->data['attrs']['category_filter_id']);

        if($answerContent->result === null){
            if($answerContent->error){
                echo $this->reportError($answerContent->error, true);
            }
            return false;
        }
        $this->data['results'] = $answerContent->result;
    }
}
