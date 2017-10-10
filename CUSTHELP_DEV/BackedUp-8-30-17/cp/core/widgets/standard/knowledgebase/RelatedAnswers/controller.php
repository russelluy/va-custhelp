<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class RelatedAnswers extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        $this->data['appendedParameters'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']) . '/related/1' . \RightNow\Utils\Url::sessionParameter();
        if($answerID = \RightNow\Utils\Url::getParameter('a_id')) {
            $relatedAnswers = $this->CI->model('Answer')->getRelatedAnswers($answerID, $this->data['attrs']['limit']);
            if($relatedAnswers->error || (is_array($relatedAnswers->result) && count($relatedAnswers->result) === 0))
                return false;
            $this->data['relatedAnswers'] = $relatedAnswers->result;
            foreach($this->data['relatedAnswers'] as $answer){
                $answer->FormattedTitle = $answer->Title;
            }
            if(($this->data['attrs']['highlight'] && ($searchTerm = \RightNow\Utils\Url::getParameter('kw'))) || $this->data['attrs']['truncate_size']) {
                foreach($this->data['relatedAnswers'] as $answer){
                    if($this->data['attrs']['truncate_size']){
                        $answer->FormattedTitle = \RightNow\Utils\Text::truncateText($answer->FormattedTitle, $this->data['attrs']['truncate_size']);
                    }
                    if($this->data['attrs']['highlight'] && $searchTerm){
                        $answer->FormattedTitle = \RightNow\Utils\Text::emphasizeText($answer->FormattedTitle);
                    }
                }
            }
        }
        else {
            return false;
        }
    }
}
