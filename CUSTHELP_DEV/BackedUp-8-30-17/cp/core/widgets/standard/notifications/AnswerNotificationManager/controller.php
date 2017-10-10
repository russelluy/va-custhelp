<?php /* Originating Release: May 2016 */


namespace RightNow\Widgets;

class AnswerNotificationManager extends \RightNow\Libraries\Widget\Base
{
    function __construct($attrs)
    {
        parent::__construct($attrs);
    }

    function getData()
    {
        $this->data['js']['duration'] = \RightNow\Utils\Config::getConfig(ANS_NOTIF_DURATION);
        $this->data['notifications'] = array();
        $answerNotifications = $this->CI->model('Notification')->get('answer')->result['answer'] ?: array();
        $answerNotifications = \RightNow\Utils\Framework::sortBy($answerNotifications, true, function($notification) { return $notification->StartTime; });

        foreach($answerNotifications as $notification) {
            $notificationDetails = array(
                'startDate' => \RightNow\Utils\Framework::formatDate($notification->StartTime, 'default', null),
                'summary' => $notification->Answer->Summary,
                'id' => $notification->Answer->ID,
                'url' => \RightNow\Utils\Url::addParameter($this->data['attrs']['url'], 'a_id', $notification->Answer->ID) . \RightNow\Utils\Url::sessionParameter()
            );

            if($this->data['js']['duration'] > 0)
                $notificationDetails['expiresTime'] = $notification->ExpireTime;

            $this->data['notifications'][] = $notificationDetails;
        }
    }
}
