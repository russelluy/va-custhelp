<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

use RightNow\Utils\Config,
    RightNow\Utils\Text,
    RightNow\Utils\Url,
    RightNow\Utils\Okcs;

class AnswerTitle extends \RightNow\Libraries\Widget\Base {
    private $answerViewApiVersion = 'v1';
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        if (!$this->helper('Okcs')->checkOkcsEnabledFlag($this->getPath())) {
            return false;
        }
        $docID = Url::getParameter('a_id');
        $locale = Url::getParameter('loc');
        $searchCacheData = Url::getParameter('s');
        $answerData = Url::getParameter('answer_data');
        $noTitleLabel = trim($this->data['attrs']['label_no_title']);
        $answerID = Text::getSubstringBefore(Url::getParameter('s'), '_');
        $searchSession = Text::getSubstringAfter(Url::getParameter('s'), '_');
        $searchData = array('answerId' => $answerID, 'searchSession' => $searchSession, 'prTxnId' => Url::getParameter('prTxnId'), 'txnId' => Url::getParameter('txnId'));
        $answer = $this->CI->model('Okcs')->getAnswerViewData($docID, $locale, $searchData, $answerData, $this->answerViewApiVersion);
        if ($answer['error']) {
            echo $this->reportError($this->CI->model('Okcs')->formatErrorMessage($answer['error']));
            return false;
        }
        $this->data = $answer;
        if(($this->data['title'] === Config::getMessage(NO_TTLE_LBL)) && $noTitleLabel !== '') {
            $this->data['title'] = $noTitleLabel;
        }
        else {
            $this->data['title'] = Text::escapeHtml($this->data['title']);
        }
    }
}
