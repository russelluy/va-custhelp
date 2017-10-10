<?php

namespace RightNow\Controllers;
use RightNow\Utils\Text,
    RightNow\Utils\Url;

/**
 * Endpoint for retrieving and displaying file attachments.
 */
class OkcsFattach extends Base {
    const INVALID_CACHE_KEY = 'N';
    public function __construct() {
        parent::__construct();
        require_once CORE_FILES . 'compatibility/Internal/OkcsApi.php';
        $this->okcsApi = new \RightNow\compatibility\Internal\OkcsApi();
    }

    /**
     * Retrieves file attachment given an ID. Sends the file content to the browser.
     * @param int $answerID ID of the file attachment
     * @param object $attachmentData Attachment data to send to the client
    */
    public function get($answerID, $attachmentData = null) {
        $status = 'PUBLISHED';
        if(is_null($attachmentData)) {
            if(!Text::stringContains($answerID, '_')) 
                Url::redirectToErrorPage(1);

            $position = (int)Text::getSubstringAfter($answerID, '_');
            if($position > 0) {
                $answerID = Text::getSubstringBefore($answerID, '_');
                if(Text::stringContains($answerID, '_')) {
                    $status = 'DRAFT';
                    $answerID = Text::getSubstringBefore($answerID, '_');
                }
                $attachmentData = $this->model('Okcs')->getArticle($answerID, $status);
                $resourceUrl = $attachmentData->resourcePath;
                $attachmentData = $attachmentData->xml;
                for($counter = 1; $counter <= $position; $counter++) {
                    $attachmentData = Text::getSubstringAfter($attachmentData, '<![CDATA[');
                }
                if(!$attachmentData) 
                    Url::redirectToErrorPage(1);

                $fileName = Text::getSubstringBefore($attachmentData, ']]>');
                $attachmentUrl = $resourceUrl . $fileName;
                $fileName = rawurldecode($fileName);
            }
            else {
                Url::redirectToErrorPage(1);
            }
        }
        else {
            if($attachmentData === self::INVALID_CACHE_KEY)
                 Url::redirectToErrorPage(1);
            $answerList = (array)json_decode($this->okcsApi->getCacheData($attachmentData));
            $user = \RightNow\Utils\Framework::isLoggedIn() ? $this->model('Contact')->get()->result->Login : 'guest';
            if ($answerList['user'] !== $user) 
                Url::redirectToErrorPage(4);

            foreach ($answerList as $key => $answer) {
                if($key === $answerID) break;
            }
            $answerID = Text::getSubstringBefore($answer, '/file/');
            if(Text::stringContains($answerID, '_')) {
                $status = 'DRAFT';
                $answerID = Text::getSubstringBefore($answerID, '_');
            }
            $fileResourcePath = $this->model('Okcs')->getArticle($answerID, $status)->resourcePath;
            $fileName = $this->model('Okcs')->decodeAndDecryptData(Text::getSubstringAfter($answer, '/file/'));
            if(Text::stringContains($fileName, '#xml='))
                $fileName = Text::getSubstringBefore($fileName, '#xml=');
            $attachmentUrl = $fileResourcePath . $fileName;
            $fileName = rawurldecode($fileName);
        }
        $attachmentInfo = array(
            'name'          => $fileName,
            'userFileName'  => $fileName,
            'attachmentUrl' => $attachmentUrl,
            'mimeType'      => $this->getMimeType(next(explode('.', $fileName)))
        );
        $this->_sendContent($attachmentInfo);
    }

    /**
     * Sends the file attachment content to the client. Split out mainly to avoid duplication
     * with the InlineImage controller
     * @param array $attachment Attachment to send to the client
     * @param boolean $preventBrowserDisplay Prevent the file from being displayed in a browser
     */
    protected function _sendContent($attachment, $preventBrowserDisplay = false) {
        header("Content-Disposition: {$this->_getContentDisposition($attachment['userFileName'], $fileSize, $preventBrowserDisplay)}; filename=\"" . $attachment['userFileName'] . "\"");
        header(gmstrftime('Date: %a, %d %b %Y %H:%M:%S GMT'));
        header('Accept-Ranges: none'); // This means we don't allow the client to start up a request for the file in the middle.
        header('Content-Transfer-Encoding: binary');
        if ($attachment['mimeType'])
            header("Content-Type: {$attachment['mimeType']}");

        \RightNow\Utils\Framework::killAllOutputBuffering();
        $response = $this->okcsApi->getAttachment($attachment['attachmentUrl'], $attachment['mimeType']);
        if(Text::beginsWith($response, 'ERROR')) {
            $errorCode = Text::getSubstringAfter($response, ':');
            Url::redirectToErrorPage($errorCode);
        }
        else {
            echo $response;
        }
    }

    /**
     * Determines the value to send in the Content-Disposition header when sending the file
     * @param string $userFileName Name of the file
     * @param int $fileSize Size of the file in bytes
     * @param boolean $preventBrowserDisplay Prevent the file from being display in a browser
     * @return string Type of header to send, either 'attachment' or 'inline'
     */
    private function _getContentDisposition($userFileName, $fileSize, $preventBrowserDisplay = false) {
        // Fix to get around IE and Excel 07's warning message, IE and Word 07's pop-under behavior.
        if (preg_match("@[.](?:xl[a-z]{1,2}|doc[a-z]?)$@i", $userFileName) ||
            // Fix for maximum file size to open 'inline' is 20MB - QA 091226-000001.
            ($fileSize > 20 * 1024 * 1024) ||
            // Force the Content-Disposition to 'attachment' for Android phones.
            Text::stringContainsCaseInsensitive($_SERVER['HTTP_USER_AGENT'], 'Android') ||
            // For security purposes some customers may want to prevent certain attachments from being display in the browser
            $preventBrowserDisplay)
        {
            return 'attachment';
        }
        return 'inline';
    }

    /**
     * Mime Types
     * @param string $ext File extension
     * @return string File mime type
     */
    private function getMimeType($ext = "") {
        $mimes = array(
            'doc'    => 'application/msword',
            'pdf'    => 'application/pdf',
            'xls'    => 'application/vnd.ms-excel',
            'ppt'    => 'application/vnd.ms-powerpoint',
            'gif'    => 'image/gif',
            'jpeg'   => 'image/jpeg',
            'jpg'    => 'image/jpeg',
            'jpe'    => 'image/jpeg',
            'png'    => 'image/png',
            'txt'    => 'text/plain',
            'text'   => 'text/plain',
            'log'    => 'text/plain',
            'rtx'    => 'text/richtext',
            'rtf'    => 'text/rtf',
            'xml'    => 'text/xml',
            'xsl'    => 'text/xml',
            'mpeg'   => 'video/mpeg',
            'mpg'    => 'video/mpeg',
            'mpe'    => 'video/mpeg',
            'doc'    => 'application/msword',
            'word'   => 'application/msword',
            'xl'     => 'application/excel',
            'html'   => 'text/plain',
            'htm'    => 'text/plain',
            'js'     => 'text/plain',
        );
        return (!isset($mimes[strtolower($ext)])) ? "application/octet-stream" : $mimes[strtolower($ext)];
    }
}