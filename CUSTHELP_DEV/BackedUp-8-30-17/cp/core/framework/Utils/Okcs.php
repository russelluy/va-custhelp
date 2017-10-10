<?php
namespace RightNow\Utils;

use RightNow\Api,
    RightNow\ActionCapture;

require_once CPCORE . 'Utils/Okcs.php';

/**
 * Methods for dealing with okcs search result related functionality.
 */
final class Okcs {
    private $schemaAttributes;
    private $contentView;
    private $schemaData;
    private $currentSchemaType = "CHANNEL";
    private $currentElement;
    private $fileName;
    private $filePosition;
    private $listOption;
    private $resourcePath;
    private $xPath = array();

    const FILE_ATTRIBUTE = 'FILE';
    const BOOLEAN_ATTRIBUTE = 'BOOLEAN';
    const CHECKBOX_ATTRIBUTE = 'CHECKBOX';
    const LIST_ATTRIBUTE = 'LIST';
    const DATE_ATTRIBUTE = 'DATE';
    const DATETIME_ATTRIBUTE = 'DATETIME';
    const TIME_ATTRIBUTE = 'TIME';
    const DISPLAY_ATTRIBUTE = 'DISPLAY';
    const RICHTEXT_ATTRIBUTE = 'WYSIWYG_EDIT';
    const DEFAULT_SCHEMA = 'CHANNEL';
    const NODE_TYPE = 'NODE';

    /**
    * This method returns an array of answer details
    * Each content object contains schema attribute header and corresponding details
    * @param string $contentXML Content xml string
    * @param array $channelSchemaAttributes Array of channel schema attrubtes
    * @param string $schemaType Type of content schema
    * @param string $resourcePath File resource path
    * @return array Answer details
    */
    public function getAnswerView($contentXML, $channelSchemaAttributes, $schemaType, $resourcePath) {
        $this->contentView = array();
        $this->xPath = array();
        $this->xpathCount = array();
        $this->filePosition = 0;
        if(!is_null($contentXML) && !is_null($channelSchemaAttributes) && is_array($channelSchemaAttributes)) {
            $this->resourcePath = is_null($resourcePath) ? '' : $resourcePath;
            $this->currentSchemaType = ($schemaType === null || $schemaType === '') ? self::DEFAULT_SCHEMA : $schemaType;
            foreach ($channelSchemaAttributes as &$attribute) {
                self::getSchemaNodeAttributes($attribute, $schemaType);
            }
            $this->schemaData = '';
            // @codingStandardsIgnoreStart
            $xmlParser = xml_parser_create();
            xml_set_element_handler($xmlParser, array('self', 'startElementHandler'), array('self', 'endElementHandler'));
            xml_set_character_data_handler($xmlParser, array('self', 'dataHandler'));
            xml_parse($xmlParser, $contentXML, true);
            // @codingStandardsIgnoreEnd
        }
        return $this->getValidContentAttributes($this->contentView);
    }

    /**
    * This handler is called when the XML parser encounters the beginning of an element
    * @param object $parser Reference to the XML parser
    * @param string $tagElement Tag element
    */
    protected function startElementHandler($parser, $tagElement) {
        // Pacify PHP_CodeSniffer's unused variable check.
        assert($parser || true);
        $this->currentElement = $tagElement;
        array_push($this->xPath, $tagElement);
        $xPath = implode("/", $this->xPath);
        $size = count($this->contentView);
        $contentKey = $xPath;
        $depth = count($this->xPath) - 1;
        $contentSchema = $this->schemaAttributes[$this->currentSchemaType . "_" . '//'. $xPath];
        if($depth === 0 || !is_null($contentSchema['name'])){
            if($this->xpathCount[$xPath] !== null) {
                $pathCount = $this->xpathCount[$xPath];
                $xPath = $xPath . '-' . $pathCount;
            }
            $contentKey = $xPath;
            $this->contentView[$contentKey] = array('name' => $contentSchema['name'], 'type' => self::NODE_TYPE, 'xPath' => $xPath, 'depth' => $depth);
            if($contentSchema['type'] !== null)
                $this->filePosition++;
        }
    }

    /**
    * This handler is called when the XML parser encounters the end of an element
    * @param object $parser Reference to the XML parser
    * @param string $tagElement Tag element
    */
    protected function endElementHandler($parser, $tagElement) {
        // Pacify PHP_CodeSniffer's unused variable check.
        assert($parser || $tagElement || true);
        $xPath = implode("/", $this->xPath);
        $depth = count($this->xPath) - 1;
        $index = count($this->contentView) - 1;
        $contentSchema = $this->schemaAttributes[$this->currentSchemaType . "_" . '//' . $xPath];
        $attributeType = $contentSchema['type'];
        $attributeName = $contentSchema['name'];
        if($this->xpathCount[$xPath] !== null) {
            $pathCount = $this->xpathCount[$xPath];
            $this->xpathCount[$xPath] = $pathCount + 1;
            $xPath = $xPath . '-' . $pathCount;
        }
        else{
            $this->xpathCount[$xPath] = 1;
        }
        $contentKey = $xPath;
        if(!is_null($attributeName)){
            if($attributeType === self::FILE_ATTRIBUTE) {
                $href = $this->resourcePath . $this->fileName;
                $fileName = rawurldecode($this->fileName);
                $this->contentView[$contentKey] = array('name' => $attributeName, 'value' => $fileName, 'type' => self::FILE_ATTRIBUTE, 'filePath' => $href, 'xPath' => $xPath, 'depth' => $depth, 'position' => $this->filePosition);
                $this->currentElement = '';
                $this->fileName = '';
            }
            else if($attributeType === self::LIST_ATTRIBUTE) {
                $this->contentView[$contentKey] = array('name' => $attributeName, 'value' => html_entity_decode($this->listOption), 'type' => self::LIST_ATTRIBUTE, 'xPath' => $xPath, 'depth' => $depth);
                $this->listOption = '';
            }
            else if($attributeType === self::BOOLEAN_ATTRIBUTE) {
                $this->contentView[$contentKey] = array('name' => $attributeName, 'value' => $this->schemaData, 'type' => self::CHECKBOX_ATTRIBUTE, 'xPath' => $xPath, 'depth' => $depth);
            }
            else {
                if($this->schemaData !== '')
                    $this->contentView[$contentKey] = array('name' => $attributeName, 'type' => self::DISPLAY_ATTRIBUTE, 'value' => html_entity_decode($this->schemaData), 'xPath' => $xPath, 'depth' => $depth);
            }
        }
        $this->schemaData = '';
        array_pop($this->xPath);
    }

    /**
    * This method handles all of the text between elements (character data, or CDATA in XML terminology)
    * @param object $parser Reference to the XML parser
    * @param string $data Text between elements
    */
    function dataHandler($parser, $data){
        // Pacify PHP_CodeSniffer's unused variable check.
        assert($parser || true);
        $attributeType = $this->schemaAttributes[$this->currentSchemaType . "_" . '//' . implode("/", $this->xPath)]['type'];
        if ($attributeType === self::FILE_ATTRIBUTE) {
            $this->fileName .= rawurlencode($data);
        }
        else {
            if($attributeType === self::DATE_ATTRIBUTE || $attributeType === self::DATETIME_ATTRIBUTE || $attributeType === self::TIME_ATTRIBUTE) {
                if(Text::stringContains($data, 'ok-highlight-sentence')) {
                    $actualData = $data;
                    $data = $dateValue = strip_tags($actualData);
                }
                $data = self::formatDate($data, $attributeType);
                if(!is_null($actualData))
                    $data = str_replace($dateValue, $data, $actualData);
            }
            else {
                $data = Text::escapeHtml($data);
            }
            if ($attributeType === null){
                if($this->currentElement !== self::DISPLAY_ATTRIBUTE)
                    $data = '';
                else
                    $this->listOption = $data;
            }
            if($data !== '' && $data !== null)
                $this->schemaData .= $data;
        }
        $data = '';
    }

    /**
    * This method populates an array of schema attribute objects.
    * @param array $schemaAttribute Array of schema attributes
    * @param string $schemaType Content schema type
    */
    function getSchemaNodeAttributes($schemaAttribute, $schemaType) {
        $this->schemaAttributes[$schemaType . "_" . $schemaAttribute->xpath] = array('name' => $schemaAttribute->name, 'type' => $schemaAttribute->schemaAttrType);
        if ($schemaAttribute->children !== null && count($schemaAttribute->children) > 0) {
            foreach($schemaAttribute->children as $childItem) {
                if ($childItem->children !== null && count($childItem->children) > 0) {
                    self::getSchemaNodeAttributes($childItem, $schemaType);
                }
                else {
                    $this->schemaAttributes[$schemaType . "_" . $childItem->xpath] = array('name' => $childItem->name, 'type' => $childItem->schemaAttrType);
                }
            }
        }
        else {
            $this->schemaAttributes[$schemaType . "_" . $schemaAttribute->xpath] = array('name' => $schemaAttribute->name, 'type' => $schemaAttribute->schemaAttrType);
        }
    }

    /**
     * Return a formatted date/time
     * @param staring $date Document date value
     * @param string $attributeType Type of schema attribute. possible values are 'DATE', 'DATETIME' and 'TIME'.
     * @return string The formatted date/time string
     */
    function formatDate($date, $attributeType) {
        date_default_timezone_set(Config::getConfig(TZ_INTERFACE));
        $dateFormat = $attributeType === self::DATE_ATTRIBUTE ? 'm/d/Y' : ($attributeType === self::DATETIME_ATTRIBUTE ? 'm/d/Y H:i A' : 'H:i A');
        return date($dateFormat, date_format(date_create_from_format('Y-m-d H:i:s T', $date), 'UTC'));
    }

    /**
    * Method returns file descriptions
    * @return array Array of file description
    */
    function getFileDescription() {
        return array(
            'document_plain_green' => Config::getMessage(PLAIN_GREEN_FILE_LBL),
            'cms_xml' => Config::getMessage(CMS_XML_FILE_LBL),
            'doc' => Config::getMessage(DOCUMENT_FILE_LBL),
            'html' => Config::getMessage(HTML_FILE_LBL),
            'image' => Config::getMessage(IMAGE_FILE_LBL),
            'iqxml' => Config::getMessage(IQXML_FILE_LBL),
            'ms_excel' => Config::getMessage(MS_EXCEL_FILE_LBL),
            'ms_powerpoint' => Config::getMessage(MS_POWERPOINT_FILE_LBL),
            'ms_word' => Config::getMessage(MS_WORD_FILE_LBL),
            'news' => Config::getMessage(NEWS_FILE_LBL),
            'pdf' => Config::getMessage(PDF_FILE_LBL),
            'rtf' => Config::getMessage(RTF_FILE_LBL),
            'table' => Config::getMessage(TABLE_FILE_LBL),
            'text' => Config::getMessage(TEXT_FILE_LBL),
            'xls' => Config::getMessage(SPREADSHEET_FILE_LBL),
            'intent' => Config::getMessage(INTENT_ICON_LBL),
            'message' => Config::getMessage(MESSAGE_ICON_LBL),
            'messages' => Config::getMessage(MESSAGES_ICON_LBL),
            'trail_arrow' => Config::getMessage(TRAIL_ARROW_ICON_LBL),
            'wizard_marker' => Config::getMessage(WIZARD_MARKER_ICON_LBL),
            'wizard_marker_rtl' => Config::getMessage(WIZARD_MARKER_RTL_ICON_LBL)
        );
    }

    /**
    * This method returns array of valid attributes
    * @param array $contentAttributes Array of content attributes
    * @return array Array of valid content attributes
    */
    function getValidContentAttributes($contentAttributes) {
        if(is_array($contentAttributes) && !is_null($contentAttributes)) {
            foreach($contentAttributes as $key => $attribute) {
                if(!is_null($attribute['type']) && ( $attribute['type'] === self::FILE_ATTRIBUTE || $attribute['type'] === self::LIST_ATTRIBUTE ) && empty( $attribute['value'] ))
                    unset($contentAttributes[$key]);
            }
        }
        $contentAttributes['xpathCount'] = $this->xpathCount;
        return $contentAttributes;
    }

    /**
    * This method is used to log
    * error and ACS Events and timing information
    * @param array $logData Array containing all response, requestUrl, requestOrigin, acsEventName, apiDuration, postData, and tokenHeader
    */
    static function eventLog(array $logData) {
        $level = 'info';
        if ($logData['response']->result->errors !== null) {
            $level = 'error';
            if ($logData['apiDuration'] > Config::getConfig(OKCS_API_TIMEOUT)){
                // code sniffer isssue
                Api::phpoutlog($logData['requestOrigin'] . " request at: " . $logData['requestUrl'] . " was timed out");
            }
            else{
                Api::phpoutlog($logData['requestOrigin'] . " request - Url: " . $logData['requestUrl']);
                Api::phpoutlog($logData['requestOrigin'] . "- API Response: " . json_encode($logData['response']));
                if (!$logData['postData'] === null)
                    Api::phpoutlog($logData['requestOrigin'] . "- PostData: " . json_encode($logData['postData']));
                if (!$logData['tokenHeader'] === null){
                    Api::phpoutlog($logData['requestOrigin'] . "- token Header: " . $logData['tokenHeader']);
                    $level = 'fatal';
                }
            }
            ActionCapture::instrument($logData['acsEventName'], 'Request', $level, array('RequestUrl' => $logData['requestUrl'], 'RequestOrigin' => $logData['requestOrigin'], 'Response' => json_encode($logData['response']), 'PostData' => json_encode($logData['postData']), 'TokenHeader' => $logData['tokenHeader']), $logData['apiDuration']);
        }
        else
            ActionCapture::instrument($logData['acsEventName'] . '-timing', 'Request', $level, array('RequestUrl' => $logData['requestUrl'], 'RequestOrigin' => $logData['requestOrigin']), $logData['apiDuration']);
    }
}
