<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class SocialContentRating extends \RightNow\Libraries\Widget\Base {
    protected $ratingWeight = 100;
    protected $contentIDParameterName = null;
    protected $upvoteRatingScale = 1;
    protected $starRatingScale = 5;

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
            'ratingValue'        => ($ratingInfo->ContentRatingSummaries->PositiveVoteCount + $ratingInfo->ContentRatingSummaries->NegativeVoteCount),
            'alreadyRated'       => !is_null($ratingInfo->RatingValue),
            'canRate'            => $this->canRateContent(),
            'totalRatingLabel'   => $this->getTotalRatingLabel($ratingInfo->ContentRatingSummaries),
        );

        $this->data['js']['ratingScale'] = $this->{$this->data['attrs']['rating_type'] . 'RatingScale'};
        $this->data['js']['userRating'] = $ratingInfo->RatingValue / ($this->ratingWeight / $this->data['js']['ratingScale']);
    }

    /**
     * Handles the submit vote AJAX request. Echoes JSON of rating response
     * @param Array $params Post parameters having value of the button and other properties
     */
    function submitVoteHandler(array $params) {
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
                 // The rating value will be calculated based on the rating type selected.
                 // For example for rating type 'star':
                 // no. of stars selected is 2,
                 // rating scale for star rating type is 5 and
                 // rating weight is 100
                 // then rating value will be 100/5 * 2 = 40
                $userRatingValue = ($this->ratingWeight / $this->{$this->data['attrs']['rating_type'] . 'RatingScale'}) * $params['rating'];
                $rateOperation = $model->{$contentMethods[$contentType]['rateMethod']}($object, $userRatingValue);

                if($rating = $rateOperation->result){
                    $outcome = json_encode(array(
                        'ratingID' => $rating->ID,
                        'totalRatingLabel' => $this->getTotalRatingLabel($model->getTabular($contentID)->result->ContentRatingSummaries, $userRatingValue),
                    ));
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

    /**
     * Determines the total content rating for the rating type and formats it accordingly
     * @param object $ratingSummary ContentRatingSummaries object
     * @param int $newRating New rating added to the content
     * @return string|null Calculated Content Rating string
     */
    protected function getTotalRatingLabel($ratingSummary, $newRating = 0) {
        if(empty($newRating)) {
            if(($totalVotes = $ratingSummary->PositiveVoteCount + $ratingSummary->NegativeVoteCount) === 0)
                return;
        }
        else {
            // If new rating is present then increase the vote count
            $totalVotes = (++$ratingSummary->PositiveVoteCount) + $ratingSummary->NegativeVoteCount;
        }

        if($this->data['attrs']['rating_type'] === 'star') {
            $ratingValue = round(($ratingSummary->RatingTotal + $newRating) / $totalVotes * ($this->starRatingScale / $this->ratingWeight), 1);
            $ratingString = $ratingValue . "/{$this->starRatingScale}";
        }
        else {
            $ratingString = $ratingSummary->PositiveVoteCount;
        }

        // Rating formating for star would be for e.g Rating: 4.3/5 (5 users)
        // and formating for upvote would be Rating: 4 (5 users)
        return sprintf(($totalVotes === 1 ? $this->data['attrs']['label_rating_singular'] : $this->data['attrs']['label_rating_plural']), $ratingString, $totalVotes);
    }
}
