<?php /* Originating Release: November 2014 */

namespace Custom\Widgets\input;

class CustomFileAttachmentUploadNew extends \RightNow\Widgets\FileAttachmentUpload {
    function __construct($attrs){
        parent::__construct($attrs);
    }

    function getData(){
        $this->data['js']['name'] = $this->data['attrs']['name'] = "Incident.FileAttachments";

        if (parent::getData() === false) return false;

        //Check if incident already has max number of file attachments
        if($incident = $this->CI->model('Incident')->get(\RightNow\Utils\Url::getParameter('i_id'))->result)
        {
            $this->data['js']['attachmentCount'] = ($incident->FileAttachments) ? count($incident->FileAttachments) : 0;
        }
        
        if($this->data['attrs']['max_attachments'] !== 0 && $this->data['attrs']['min_required_attachments'] > $this->data['attrs']['max_attachments'])
        {
            echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(PCT_S_PCT_S_LBL), 'min_required_attachments', 'max_attachments'));
            return false;
        }
    }
}
