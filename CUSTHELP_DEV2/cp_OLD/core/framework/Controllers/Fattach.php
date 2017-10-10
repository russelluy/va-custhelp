<?php

namespace RightNow\Controllers;
use RightNow\Utils\Url,
    RightNow\Utils\Text,
    RightNow\Api;

/**
 * Endpoint for retrieving and displaying file attachments.
 */
class Fattach extends Base
{
    /**
     * Error message returned when file uploaded has no size
     * @internal
     */
    const EMPTY_FILE_ERROR = 10;

    /**
     * Error returned when a non-specific error occured
     * @internal
     */
    const GENERIC_ERROR = 2;

    public function __construct()
    {
        parent::__construct();
        parent::_setClickstreamMapping(array(
            "get" => "attachment_view",
            "upload" => "attachement_upload"
        ));
    }

    /**
     * Retrieves file attachment given an ID. Sends the file content to the browser.
     * @param int $id ID of the file attachment
     * @param string $created Created timestamp
     */
    public function get($id, $created = null)
    {
        $attachment = $this->model('FileAttachment')->get($id, $created);

        // If contact is not logged in and the attachment belongs to a privileged answer
        // redirect to login page
        if ($attachment->warnings && !\RightNow\Utils\Framework::isLoggedIn())
        {
            $this->_loginRedirect();
        }

        // if an attachment was not returned for various reasons, redirect to error page
        $attachment = $attachment->result;
        if (!$attachment || !$attachment->localFileName)
        {
            $this->_accessError();
        }

        //Allow customers to prevent certain files from being displayed in the browser
        $attachmentData = array(
            'name' => $attachment->userFileName,
            'size' => $attachment->size,
            'mimetype' => $attachment->contentType,
            'preventBrowserDisplay' => false
        );

        \RightNow\Libraries\Hooks::callHook('pre_attachment_download', $attachmentData);
        $this->_sendContent($attachment, (bool)$attachmentData['preventBrowserDisplay']);
    }

    /**
     * Renames a temporary uploaded file and returns all
     * information about the file.
     */
    public function upload()
    {
        $fileInfo = $_FILES['file'];
        if($fileInfo['error'] === UPLOAD_ERR_NO_FILE)
        {
            $this->_uploadError(FILE_PATH_FOUND_MSG, UPLOAD_ERR_NO_FILE);
        }
        if($fileInfo['size'] === false || $fileInfo['size'] === null || ($fileInfo['error'] > 0))
        {
            $this->_uploadError(\RightNow\Utils\Config::getMessage(FILE_SUCC_UPLOADED_FILE_PATH_FILE_MSG), self::GENERIC_ERROR);
        }
        if($fileInfo['size'] === 0)
        {
            $this->_uploadError(null, self::EMPTY_FILE_ERROR);
        }
        if($fileInfo['size'] > \RightNow\Utils\Config::getConfig(FATTACH_MAX_SIZE))
        {
            $this->_uploadError(\RightNow\Utils\Config::getMessage(SORRY_FILE_TRYING_UPLOAD_MSG));
        }

        $attachmentData = array(
            'name' => $fileInfo['name'],
            'size' => $fileInfo['size'],
            'mimetype' => $fileInfo['type']
        );

        $customHookError = \RightNow\Libraries\Hooks::callHook('pre_attachment_upload', $attachmentData);
        if(is_string($customHookError)) {
            $this->_uploadError($customHookError);
        }

        $temporaryName = $fileInfo['tmp_name'];
        $temporaryName = basename(strval($temporaryName));
        $temporaryName = substr($temporaryName, 3) . $_SERVER['SERVER_NAME'];
        $newName = Api::fattach_full_path($temporaryName);

        @unlink($newName);
        if(@rename($_FILES['file']['tmp_name'], $newName))
        {
            chmod($newName, 0666);
            if(IS_HOSTED && !Api::fas_put_tmp_file($newName))
            {
                $this->_uploadError(\RightNow\Utils\Config::getMessage(ERROR_REQUEST_ACTION_COMPLETED_MSG));
            }
        }
        else
        {
            $this->_uploadError(\RightNow\Utils\Config::getMessage(FILE_SUCC_UPLOADED_FILE_PATH_FILE_MSG), self::GENERIC_ERROR);
        }

        $fileInfo['tmp_name'] = $temporaryName;
        $fileInfo['name'] = $this->_sanitizeFilename($fileInfo['name']);

        if(strlen($fileInfo['name']) > 100)
        {
            $this->_uploadError(\RightNow\Utils\Config::getMessage(NAME_ATTACHED_FILE_100_CHARS_MSG));
        }
        if (!preg_match("@^[a-z0-9.-]+$@i", $fileInfo['tmp_name']))
        {
            $this->_uploadError(\RightNow\Utils\Config::getMessage(FILE_SUCC_UPLOADED_FILE_PATH_FILE_MSG), self::GENERIC_ERROR);
        }
        echo json_encode($fileInfo);
    }

    /**
     * Renames a temporary uploaded file and returns all
     * information about the file. This function also
     * alerts the Chat Service of the uploaded file.
     * @param int $engagementID Engagement id
     * @param string $chatSessionID Chat session id
     */
    public function uploadChat($engagementID, $chatSessionID)
    {
        // Get max file size; if this upload exceeds size, report error to chat service
        $maxFilesize = \RightNow\Utils\Config::getConfig(FATTACH_MAX_SIZE);

        // Get Chat Service URL
        $chatServerHost = \RightNow\Utils\Config::getConfig(SRV_CHAT_INT_HOST, 'RNL');
        if($chatServerHost === '')
        {
            $chatServerHost = \RightNow\Utils\Config::getConfig(SRV_CHAT_HOST, 'RNL');
            $liveServerAndPath = (Url::isRequestHttps() ? ('https://') : ('http://')) . $chatServerHost . '/Chat/chat/';
        }
        else
        {
            $liveServerAndPath = ('http://') . $chatServerHost . '/Chat/chat/';
        }

        $dbName = \RightNow\Utils\Config::getConfig(DB_NAME, 'COMMON');
        $pool = \RightNow\Utils\Config::getConfig(CHAT_CLUSTER_POOL_ID, 'RNL');
        $url = $liveServerAndPath . $dbName . ($pool === '' ? '?' : "?pool=$pool&") . 'action=FATTACH_UPLOAD';

        $postData = "&engagementID=$engagementID&sessionId=$chatSessionID";

        $fileInfo = $_FILES['file'];
        if($fileInfo['error'] === UPLOAD_ERR_NO_FILE)
            $uploadFailure = array('error' => UPLOAD_ERR_NO_FILE);
        else if(!isset($fileInfo['size']))
            $uploadFailure = array('error' => 2);
        else if($fileInfo['size'] == 0)
            $uploadFailure = array('error' => 10); // Magic number; these should be defined somewhere, probably. This means empty file was uploaded.

        if(!isset($uploadFailure))
        {
            $tempName = $fileInfo['tmp_name'];
            $tempName = basename(strval($tempName));
            $tempName = substr($tempName, 3) . $_SERVER['SERVER_NAME'];
            $newName = Api::fattach_full_path($tempName);

            @unlink($newName);
            rename($_FILES['file']['tmp_name'], $newName);
            chmod($newName, 0666);
            if(IS_HOSTED && !Api::fas_put_tmp_file($newName))
            {
                $uploadFailure = array('errorMessage' => \RightNow\Utils\Config::getMessage(ERROR_REQUEST_ACTION_COMPLETED_MSG));
                $postData .= '&status=ERROR';
            }
            else
            {
                $fileInfo['tmp_name'] = $tempName;
                $fileInfo['name'] = $this->_sanitizeFilename($fileInfo['name']);

                if(strlen($fileInfo['name']) > 100)
                {
                    $uploadFailure = array('errorMessage' => \RightNow\Utils\Config::getMessage(NAME_ATTACHED_FILE_100_CHARACTERS_MSG));
                    $postData .= '&status=ERROR';
                }
                else if (!preg_match("@^[a-z0-9.-]+$@i", $fileInfo['tmp_name']))
                {
                    $uploadFailure = array('error' => 2);
                    $postData .= '&status=ERROR';
                }
                else
                {
                    if($fileInfo['size'] <= $maxFilesize)
                    {
                        $postData .= '&' . http_build_query(array(
                            'status' => 'RECEIVED',
                            'localFName' => $tempName,
                            'userFName' => $fileInfo['name'],
                            'contentType' => $fileInfo['type'],
                            'fileSize' => $fileInfo['size'],
                        ));
                    }
                    else
                    {
                        $postData .= '&status=ERROR'; // max filesize exceeded; report error to chat service
                    }
                }
            }
        }
        else
        {
            //error encountered; notify Chat Service and return json error
            $postData .= '&status=ERROR';
        }

        $handle = fopen($url . $postData, 'r');

        if ($handle === false)
        {
            exit("-1");
        }

        $contents = '';
        while (!feof($handle))
            $contents .= fread($handle, 8192);

        fclose($handle);

        if(isset($uploadFailure))
            echo json_encode($uploadFailure);
        else
            echo json_encode($fileInfo);
    }

    /**
     * Checks the given filename for bad characters and adjusts as necessary, returning the potentially modified file name.
     * @param string $filename Name of the uploaded file
     */
    protected function _sanitizeFilename($filename) {
        // The name shouldn't have tag delimiters but it also
        // should not have single or double quotes in it to prevent
        // denial of service attacks.

        if(preg_match("@(<|&lt;).*(>|&gt;)@i", $filename))
        {
            $rnow = $this->rnow ?: get_instance()->rnow; // use get_instance for unit testing
            $filename = strtr($filename, $rnow->getFileNameEscapeCharacters());
        }

        // QA ID 130816-000062: Replace some characters with underscores which can cause some errors downstream
        $filename = preg_replace("/[\r\n\/:*?|]+/", '_', $filename);

        return strtr($filename, "\"'", "--");
    }

    /**
     * Sends the file attachment content to the client. Split out mainly to avoid duplication
     * with the InlineImage controller
     * @param object $attachment Attachment to send to the client
     * @param boolean $preventBrowserDisplay Prevent the file from being displayed in a browser
     */
    protected function _sendContent($attachment, $preventBrowserDisplay = false){
        list($streamFunction, $fileSize) = $this->_getTransferDetails($attachment->localFileName, $attachment->size);
        if (!$streamFunction){
            $this->_accessError(3);
        }

        header("Content-Disposition: {$this->_getContentDisposition($attachment->userFileName, $fileSize, $preventBrowserDisplay)}; filename=\"" . $attachment->userFileName . "\"");
        header(gmstrftime('Date: %a, %d %b %Y %H:%M:%S GMT')); // RFC 2822
        header('Accept-Ranges: none'); // This means we don't allow the client to start up a request for the file in the middle.

        $contentType = ($preventBrowserDisplay) ? 'application/octet-stream' : $attachment->contentType;
        if ($contentType) {
            header("Content-Type: $contentType{$this->_getCharsetFor($contentType, $attachment->localFileName, $streamFunction, $fileSize)}");
        }

        \RightNow\Utils\Framework::killAllOutputBuffering();
        $this->_stream($streamFunction, $attachment->localFileName);
    }

    /**
     * Determines the value to send in the Content-Disposition header when sending the file
     * @param string $userFileName Name of the file
     * @param int $fileSize Size of the file in bytes
     * @param boolean $preventBrowserDisplay Prevent the file from being display in a browser
     * @return string Type of header to send, either 'attachment' or 'inline'
     */
    private function _getContentDisposition($userFileName, $fileSize, $preventBrowserDisplay = false)
    {
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
     * Returns details about how to serve the file and where it's located
     *
     * @param string $localFileName Temporary file name on disk.
     * @param int $fileSize Size of file
     *
     * @return array|boolean Method to use to retrieve file and it's size, or false if temporary file name wasn't found
     */
    private function _getTransferDetails($localFileName, $fileSize)
    {
        // Is it a regular file on disk?  I think this is only used in non-hosted environments, but I'm
        // not sure enough of that to modify the code to codify that assumption.
        if(\RightNow\Utils\FileSystem::isReadableFile($localFileName))
        {
            return array('readfile', $fileSize ?: filesize($localFileName));
        }

        if (IS_HOSTED && Api::fas_enabled())
        {
            // Is it in the File Attachment Server?
            if (Api::fas_has_file($localFileName))
            {
                return array('fas_get', $fileSize ?: Api::fas_get_filesize($localFileName));
            }

            // Is it a temporary file in the File Attachment Server?
            if (Api::fas_has_tmp_file($localFileName))
            {
                return array('fas_get_tmp_file', $fileSize ?: Api::fas_get_tmp_filesize($localFileName));
            }
        }

        return false;
    }

    /**
     * Gets the charset to use provide the filename and it's content type
     *
     * @param string $contentType Content type of file attachment
     * @param string $localFileName Temporary name of file attachment
     * @param string $streamFunction API method to use to retrieve file attachment
     * @param int $fileSize Size of file
     * @return string Character set header to send for file attachment
     */
    private function _getCharsetFor($contentType, $localFileName, $streamFunction, $fileSize)
    {
        // We only want to determine the character set for text-y things because binary stuff
        // doesn't really have a charset.  We want to avoid detecting the charset for content larger
        // than 1 MB because the API will die if we try.
        if (in_array(strtolower($contentType), array('text/plain', 'text/html')) && $fileSize && $fileSize < (1 * 1024 * 1024))
        {
            ob_start();
            $this->_stream($streamFunction, $localFileName);
            $attachmentContent = ob_get_clean();
            $charset = $this->_getBrowserFriendlyCharset($attachmentContent);
            if ($charset)
            {
                return ";charset={$charset}";
            }
        }
        return "";
    }

    /**
     * Returns the charset for the file provided the files content.
     *
     * @param string $text Text of attachment
     *
     * @return string Encoding to send to the browser
     */
    private function _getBrowserFriendlyCharset($text)
    {
        $encoding = Api::lang_detect_encoding($text);
        switch (strtoupper($encoding))
        {
            // I tried IE, FF, and Chrome and none of them liked ISO-2022-(KR|CN), so I had to fall back to the older equivalents.
            case "ISO-2022-KR":
                return "EUC-KR";
            case "ISO-2022-CN":
                return "GB2312";
        }
        return $encoding;
    }

    /**
     * Echoes a JSON-encoded error object. May contain errorMessage or error keys.
     * @param string $errorMessage Error message
     * @param int $errorCode Error code
     */
    private function _uploadError($errorMessage, $errorCode = null)
    {
        $uploadFailure = array('errorMessage' => $errorMessage);
        if($errorCode)
        {
            $uploadFailure['error'] = $errorCode;
        }
        echo json_encode($uploadFailure);
        exit;
    }

    /**
     * Sends a header pointing to the error page with an error code.
     * @param int $errorCode Error code parameter for the page
     */
    private function _accessError($errorCode = 4)
    {
        Url::redirectToErrorPage($errorCode);
    }

    /**
     * Streams the designated file.
     * @param string $streamFunction Name of the function. Should either
     *  be readfile, fas_get, or fas_get_tmp_file
     * @param string $fileName Name of the file to stream
     */
    private function _stream($streamFunction, $fileName) {
        if (method_exists('\RightNow\Api', $streamFunction)) {
            Api::$streamFunction($fileName);
        }
        else {
            $streamFunction($fileName);
        }
    }
}
