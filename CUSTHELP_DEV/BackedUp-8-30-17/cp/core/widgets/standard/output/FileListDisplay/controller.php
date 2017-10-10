<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class FileListDisplay extends \RightNow\Libraries\Widget\Output {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        if(parent::getData() === false)
            return false;

        if($this->data['attrs']['name'] === 'Answer.FileAttachments'){
            if(($answerID = \RightNow\Utils\Url::getParameter('a_id')) && ($answer = $this->CI->model('Answer')->get($answerID)->result)){
                $commonAttachments = (array)$answer->CommonAttachments;
            }
        }
        if(!$this->data['value'] || !count($this->data['value']) && !$commonAttachments && !count($commonAttachments))
            return false;

        if(!\RightNow\Utils\Connect::isFileAttachmentType($this->data['value'])){
            echo $this->reportError(\RightNow\Utils\Config::getMessage(FILELISTDISPLAY_DISP_FILE_ATTACH_MSG));
            return false;
        }
        //connect arrays are implemented as php objects, convert to php array before sorting
        $attachmentArray = (array)$this->data['value'];
        $displayingIncidents = $this->table === "Incident";
        // Adding sibling attachments
        if($commonAttachments)
            $attachmentArray = array_merge(array_values($attachmentArray), array_values($commonAttachments));
        $openInNewWindow = trim(\RightNow\Utils\Config::getConfig(EU_FA_NEW_WIN_TYPES));
        $attachmentUrl = "/ci/fattach/get/%s/%s" . \RightNow\Utils\Url::sessionParameter() . "/filename/%s";

        $showCreatedTime = \RightNow\Utils\Text::beginsWith($this->data['attrs']['name'], 'Incident.');
        foreach ($attachmentArray as $item) {
            $item->Target = ($openInNewWindow && preg_match("/{$openInNewWindow}/i", $item->ContentType)) ? '_blank' : '_self';
            $item->Icon = \RightNow\Utils\Framework::getIcon($item->FileName);
            $item->ReadableSize = \RightNow\Utils\Text::getReadableFileSize($item->Size);
            $item->AttachmentUrl = sprintf($attachmentUrl, $item->ID, $showCreatedTime ? $item->CreatedTime : 0, urlencode($item->FileName));
            // "Thumbnails" only are set for images when attribute 'display_thumbnail' is true
            $item->ThumbnailUrl = null;
            $item->ThumbnailScreenReaderText = null;
            if($this->data['attrs']['display_thumbnail'] && \RightNow\Utils\Text::beginsWith($item->ContentType, 'image')) {
                $fileExtension = pathinfo($item->AttachmentUrl, PATHINFO_EXTENSION);
                $fileExtension = \RightNow\Utils\Text::escapeHtml($fileExtension);
                $item->ThumbnailScreenReaderText = sprintf(\RightNow\Utils\Config::getMessage(FILE_TYPE_PCT_S_LBL), $fileExtension);
                // ThumbnailUrl may change in the future, but for now is the same as $item->AttachmentUrl
                $item->ThumbnailUrl = $item->AttachmentUrl;
            }
        }
        $this->data['value'] = array_values($attachmentArray);
        if ($this->data['attrs']['sort_by_filename']) {
            usort($this->data['value'], function($a, $b) {
                return strcasecmp($a->FileName, $b->FileName);
            });
        }
        // Set up label-value justification
        $this->data['wrapClass'] = ($this->data['attrs']['left_justify']) ? ' rn_LeftJustify' : '';
    }
}
