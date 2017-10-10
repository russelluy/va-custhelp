<?php
namespace RightNow\Libraries;
use RightNow\Utils\Text,
    RightNow\Api,
    RightNow\Connect\v1_2 as Connect;

/**
 * Formats data for display within CP.
 */
class Formatter
{
    private static $keywordPhrase = false;

    /**
     * Returns formatted content for the specified field. Call #formatThreadEntry in order to retrieve formatted HTML content for Incident threads.
     * @param int|bool|string|object $fieldValue Field value
     * @param object $fieldMetaData Metadata for the field
     * @param boolean $highlight Whether to highlight content matching the `kw` URL parameter
     * @return string|null Formatted field value
     */
    public static function formatField($fieldValue, $fieldMetaData, $highlight){
        if ($fieldValue === null && $fieldMetaData->is_nillable) {
            return null;
        }
        if(\RightNow\Utils\Connect::isNamedIDType($fieldValue) || \RightNow\Utils\Connect::isAssetType($fieldValue)) {
            $fieldMetaData = $fieldValue::getMetadata()->LookupName;
            $fieldValue = $fieldValue->LookupName;
        }
        else if(\RightNow\Utils\Connect::isCountryType($fieldValue)) {
            $fieldMetaData = $fieldValue::getMetadata()->LookupName;
            $fieldValue = $fieldValue->Name;
        }
        else if(\RightNow\Utils\Connect::isSlaInstanceType($fieldValue)){
            $fieldValue = $fieldValue->NameOfSLA;
            $fieldMetaData = $fieldValue::getMetadata()->LookupName;
            $fieldValue = $fieldValue->LookupName;
        }
        else if($fieldMetaData->is_menu) {
            $fieldValue = $fieldValue->Name;
        }
        $fieldType = strtolower($fieldMetaData->COM_type);
        if($fieldType === 'datetime'){
            $fieldValue = Api::date_str(DATEFMT_DTTM, $fieldValue);
        }
        else if($fieldType === 'date'){
            $fieldValue = Api::date_str(DATEFMT_SHORT, $fieldValue);
        }
        else if($fieldType === 'boolean'){
            // 0, false, null, and any string end up as NO.
            $fieldValue = ($fieldValue == 0) ? \RightNow\Utils\Config::getMessage(NO_LBL) : \RightNow\Utils\Config::getMessage(YES_LBL);
        }
        //Escape HTML in all string types except for AnswerContent and Answer classes
        //Conveniently, custom fields are within other classes, such as the AnswerContentCustomFieldsCO class, which means those fields get escaped
        else if($fieldType === 'string'){
            if($fieldMetaData->container_class !== KF_NAMESPACE_PREFIX . '\AnswerContent' &&
                $fieldMetaData->container_class !== CONNECT_NAMESPACE_PREFIX . '\Answer') {
                $fieldValue = Api::print_text2str($fieldValue, self::getFormattingOptions(true));
            }
        }
        //Field types which don't have special handling: integer, long, decimal

        if($highlight){
            $fieldValue = self::highlight($fieldValue);
        }
        return $fieldValue;
    }

    /**
     * Returns correctly formatted Incident Text content depending on the incident's content type.
     * @param Connect\Thread $thread Thread object whose text is to be returned
     * @param boolean $highlight Whether to highlight content matching the `kw` URL parameter
     * @return string Formatted incident text
     */
    public static function formatThreadEntry(Connect\Thread $thread, $highlight) {
        $flags = self::getFormattingOptions($thread->ContentType->LookupName === 'text/plain');

        $fieldValue = Api::print_text2str($thread->Text, $flags);

        if ($highlight) {
            $fieldValue = self::highlight($fieldValue);
        }
        return $fieldValue;
    }

    /**
     * Highlights the passed in content by adding an <em> tag around any words that match the current search term.
     * @param string $fieldValue Value of field. If value is not a string, no modification will occur.
     * @return string Value with keywords highlighted
     */
    public static function highlight($fieldValue){
        if(is_string($fieldValue) && ($keyword = self::getKeyword()) !== null){
            return Text::emphasizeText($fieldValue, array('query' => $keyword));
        }
        return $fieldValue;
    }

    /**
     * Creates and returns a mask string based upon the field's value.
     * @param string $value The field's initial value
     * @param string $mask The Mask value
     * @return string The field's initial mask value
     */
    public static function applyMask($value, $mask) {
        if (strlen($value) === 0)
            return $value;

        $j = 0;
        $result = '';
        for ($i = 0; $i < strlen($mask); $i += 2) {
            while ($mask[$i] === 'F') {
                $result .= $mask[$i + 1];
                $i += 2;
            }
            $result .= $value[$j++];
        }
        return $result;
    }

    /**
     * Returns the ORed together flag value for the specified object type.
     * @param bool $escapeHtml Whether or not to escape HTML in the content
     * @return int ORed together flag value for how the object type should be formatted
     */
    private static function getFormattingOptions($escapeHtml) {
        static $commonFlags, $htmlFlags;
        if (!isset($commonFlags)) {
            $commonFlags = OPT_HTTP_EXPAND | OPT_SPACE2NBSP | OPT_ESCAPE_SCRIPT | OPT_SUPPORT_AS_HTML | OPT_REF_TO_URL_PREVIEW;
            $htmlFlags = $commonFlags | OPT_ESCAPE_HTML | OPT_NL_EXPAND;
        }
        if($escapeHtml){
            return $htmlFlags;
        }
        return $commonFlags;
    }

    /**
     * Returns the keyword for the current page.
     * @return string|null Value of keyword or null if one wasn't found
     */
    private static function getKeyword(){
        if(self::$keywordPhrase === false){
            self::$keywordPhrase = \RightNow\Utils\Url::getParameter('kw');
        }
        return self::$keywordPhrase;
    }
}
