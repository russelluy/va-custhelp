<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

use RightNow\Utils\Connect;

class TextInput extends \RightNow\Libraries\Widget\Input {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        if (parent::getData() === false) return false;
        if (!in_array($this->dataType, array('String', 'Integer', 'Thread'))) {
            echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(DATA_TYPE_PCT_S_APPR_TEXT_INPUT_MSG), $this->fieldName));
            return false;
        }

        //Certain Connect objects (e.g. Incident.Threads) are objects even when they have no value. Since we're displaying
        //the data within a text input box, it needs to be a string, so convert it to one. As we can't generically convert objects
        //into strings since we have no idea which fields to display instead, just convert things into an empty string.
        if(is_object($this->data['value'])){
            $this->data['value'] = '';
        }

        $displayType = $this->data['displayType'] = $this->determineDisplayType($this->data['inputName'], $this->dataType, $this->constraints);
        if ($this->data['attrs']['textarea']) {
            if ($displayType === 'Number' || $displayType === 'Email'
                || ($displayType === 'Text' && Connect::isCustomField($this->fieldMetaData))
                || (($regex = $this->constraints['regex']) && \RightNow\Utils\Validation::regex("a\nb", $regex, $this->fieldName))) {
                   echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(PCT_S_SUPPORT_PCT_S_ATTRIB_MSG), $this->fieldName, 'textarea'));
                   return false;
            }
            $displayType = $this->data['displayType'] = 'Textarea';
        }
        $this->data['inputType'] = strtolower($displayType);

        if($displayType === "Number" && ($this->data['attrs']['maximum_length'] > 0 || $this->data['attrs']['minimum_length'] > 0)){
            echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(FLD_PCT_S_INT_FLD_MAX_VAL_MIMIMUM_MSG), $this->fieldName));
            return false;
        }
        if($displayType !== "Number" && (isset($this->data['attrs']['maximum_value']) || isset($this->data['attrs']['minimum_value']))){
            echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(FLD_PCT_S_INT_FLD_MAX_LNG_MIMIMUM_MSG), $this->fieldName));
            return false;
        }

        if (!$this->data['readOnly']) {
            // Since Connect gives us 'maxBytes' and 'maxLength', treat them equally here so we don't unecessarily limit a blob field to its smaller character length.
            if ($maxLength = intval($this->constraints['maxBytes'] ?: $this->constraints['maxLength'])) {
                $this->constraints['maxLength'] = $this->data['js']['constraints']['maxLength'] = $maxLength;
            }

            //Only set the max length of the attribute if it's less than the DB required max length
            if($this->data['attrs']['maximum_length'] > 0){
                $maxLength = $this->constraints['maxLength'] = $this->data['js']['constraints']['maxLength'] = $this->data['constraints']['maxLength'] = ($maxLength > 0 ? min($maxLength, $this->data['attrs']['maximum_length']) : $this->data['attrs']['maximum_length']);
            }
            //If a minimum length is set, that also means the user has to input some content, thereby making it required
            if($this->data['attrs']['minimum_length'] > 0){
                if($maxLength > 0 && ($this->data['attrs']['minimum_length'] > $maxLength)){
                    echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(FLD_PCT_S_MNIMUM_LNG_PCT_D_MAX_LNG_MSG), $this->fieldName, $this->data['attrs']['minimum_length'], $maxLength));
                    return false;
                }
                $this->constraints['minLength'] = $this->data['constraints']['minLength'] = $this->data['js']['constraints']['minLength'] = $this->data['attrs']['minimum_length'];
                $this->data['attrs']['required'] = $this->data['constraints']['required'] = true;
            }

            if(isset($this->data['attrs']['maximum_value'])){
                $this->constraints['maxValue'] = (isset($this->constraints['maxValue'])) ? min($this->constraints['maxValue'], $this->data['attrs']['maximum_value']) : $this->data['attrs']['maximum_value'];
                $this->data['js']['constraints']['maxValue'] = $this->data['constraints']['maxValue'] = $this->constraints['maxValue'];
            }

            if(isset($this->data['attrs']['minimum_value'])){
                $this->constraints['minValue'] = (isset($this->constraints['minValue'])) ? max($this->constraints['minValue'], $this->data['attrs']['minimum_value']) : $this->data['attrs']['minimum_value'];
                if(isset($this->constraints['maxValue']) && ($this->data['attrs']['minimum_value'] > $this->constraints['maxValue'])){
                    echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(FLD_PCT_S_MINIMUM_VAL_PCT_D_MAX_VAL_MSG), $this->fieldName, $this->data['attrs']['minimum_value'], $this->constraints['maxValue']));
                    return false;
                }
                $this->data['js']['constraints']['minValue'] = $this->data['constraints']['minValue'] = $this->constraints['minValue'];
            }
        }

        if($this->data['attrs']['require_validation']) {
            $this->data['constraints']['requireValidation'] = true;
        }

        //Standard Field
        if(!Connect::isCustomField($this->fieldMetaData)) {
            if ($this->fieldName === 'NewPassword') {
                echo $this->reportError(\RightNow\Utils\Config::getMessage(PASSWD_FLDS_REQUIRE_PASSWORDINPUT_MSG));
                return false;
            }
            //Error if using alt first/last name fields when not on Japanese site
            if ($this->fieldName === 'NameFurigana' && LANG_DIR !== 'ja_JP') {
                echo $this->reportError(\RightNow\Utils\Config::getMessage(ALT_FIRST_NAME_ALT_LAST_NAME_FLDS_MSG));
                return false;
            }
            //Prepopulate email address field if it does not already have a value and was set on a previous email input
            if(\RightNow\Utils\Text::stringContainsCaseInsensitive($this->data['inputName'], 'Emails.Primary') && !$this->data['value'] && ($previouslySeen = $this->CI->session->getSessionData('previouslySeenEmail'))) {
                $this->data['value'] = $previouslySeen;
            }

            if ($this->data['attrs']['validate_on_blur'] === true)
                $this->data['js']['previousValue'] = $this->data['value'];
        }

        if (isset($this->data['js']['mask'])) {
            $this->data['maskedValue'] = $this->data['value'];
            $this->data['value'] = \RightNow\Libraries\Formatter::applyMask($this->data['value'], $this->data['js']['mask']);
        }

        $this->data['js']['contactToken'] = \RightNow\Utils\Framework::createTokenWithExpiration(1);
    }

    /**
     * Returns HTML attributes for an input element based on the field's
     * constraints.
     * @return string HTML attributes
     */
    public function outputConstraints() {
        $attributes = '';
        if ($maxLength = $this->constraints['maxLength']) {
            $attributes .= "maxlength='{$maxLength}' ";
        }
        if (array_key_exists('maxValue', $this->constraints)) {
            $attributes .= "max='{$this->constraints['maxValue']}' ";
        }
        if (array_key_exists('minValue', $this->constraints)) {
            $attributes .= "min='{$this->constraints['minValue']}' ";
        }
        if ($this->data['attrs']['required']) {
            $attributes .= "required ";
        }
        if ($this->data['inputName'] === 'Contact.Login') {
            $attributes .= "autocorrect='off' autocapitalize='off' ";
        }
        return trim($attributes);
    }

    /**
     * Determines the type of input for the field.
     * @param string $fieldName Field name
     * @param string $dataType Data type of the field
     * @param array|null $constraints Field's contraints
     * @return string One of Email|Url|Number|Textarea|Text
     */
    protected function determineDisplayType($fieldName, $dataType, $constraints) {
        if (\RightNow\Utils\Text::beginsWith($fieldName, 'Contact.Emails.') || $this->data['js']['email']) {
            return 'Email';
        }
        if ($this->data['js']['url']) {
            return 'Url';
        }
        if ($dataType === 'Integer') {
            return 'Number';
        }
        if ($dataType === 'Thread') {
            return 'Textarea';
        }
        if ($constraints) {
            foreach ($constraints as $name => $constraint) {
                if ($name === 'maxLength' && $constraint <= 300) {
                    return 'Text';
                }
            }
        }

        return 'Textarea';
    }
}