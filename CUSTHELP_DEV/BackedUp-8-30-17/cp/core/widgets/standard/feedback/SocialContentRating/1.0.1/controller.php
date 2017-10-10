<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class SocialContentRating extends \RightNow\Libraries\Widget\Base {
    protected $ratingWeight = 100;
    protected $contentIDParameterName = null;

    private $question;
    private $comment;

    function __construct($attrs) {
        parent::__construct($attrs);

        $this->setAjaxHandlers(array(
            'submit_vote_ajax' => array(
                'method'      => 'submitVoteHandler',
                'clickstream' => 'social_content_rate',
            )
        ));
    }

    function getData() {
        $questionID = $this->data['attrs']['question_id'];

        if(!$this->question = $this->CI->model('SocialQuestion')->get($questionID)->result){
            return false;
        }

        if($this->data['attrs']['content_type'] === 'comment'){
            if(!$this->comment = $this->CI->model('SocialComment')->getTabular($this->data['attrs']['comment_id'])->result){
                return false;
            }
            $ratingInfo = $this->comment;
        }
        else{
            $ratingInfo = $this->CI->model('SocialQuestion')->getTabular($questionID)->result;
        }

        $this->data['js'] = array(
            'ratingValue'        => intval($ratingInfo->ContentRatingSummaries->PositiveVoteCount) ?: 0,
            'alreadyRated'       => !is_null($ratingInfo->RatingValue),
            'canRate'            => $this->canRateContent(),
        );
    }

    /**
     * Handles the submit vote AJAX request. Echoes JSON of rating response
     */
    function submitVoteHandler() {
        $outcome = array();
        $contentMethods = array(
            'question' => array('model' => 'SocialQuestion', 'rateMethod' => 'rateQuestion'),
            'comment'  => array('model' => 'SocialComment', 'rateMethod' => 'rateComment'),
        );
        $contentType = $this->data['attrs']['content_type'];

        if($contentID = intval($this->data['attrs'][$contentType . '_id'])){
            $model = $this->CI->model($contentMethods[$contentType]['model']);
            $fetched = $model->get($contentID);

            if($object = $fetched->result){
                $ratingMethod = $contentMethods[$contentType]['rateMethod'];
                $rateOperation = $model->$ratingMethod($object, $this->ratingWeight);

                if($rating = $rateOperation->result){
                    $outcome = json_encode($rating->ID);
                }
                else{
                    $outcome = $rateOperation->toJson();
                }
            }
            else{
                $outcome = $fetched->toJson();
            }
        }
        else {
            $outcome = json_encode($outcome);
        }
        $this->echoJSON($outcome);
    }

    /**
     * Determines if the current user can rate the content we're displaying.
     * @return bool Whether or not rating is allowed
     */
    protected function canRateContent(){
        $isSocialUser = \RightNow\Utils\Framework::isSocialUser();
        //If the user isn't logged in or doesn't have a social profile and the questions is non-active/locked there isn't
        //much reason to show the UI to entice them to rate since for the majority of the time they won't be able to
        if(!$isSocialUser && ($this->question->SocialPermissions->isLocked() || !$this->question->SocialPermissions->isActive())){
            return false;
        }
        //Otherwise, show the UI if the user has permission, or they're not a social user (at which point we entice them to login/add social info)
        if($this->data['attrs']['content_type'] === 'question'){
            return !$isSocialUser || $this->question->SocialPermissions->canRate();
        }
        return !$isSocialUser || $this->comment->SocialPermissions->canRate();
    }
}
