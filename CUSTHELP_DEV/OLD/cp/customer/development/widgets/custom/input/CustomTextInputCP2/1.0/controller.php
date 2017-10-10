<?php
namespace Custom\Widgets\input;

class CustomTextInput extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {

        return parent::getData();

    }
}


//   <?php /* Originating Release: August 2012 */
//   
//     if (!defined('BASEPATH')) exit('No direct script access allowed');
//   
//   if(!class_exists('FormInput'))
//       requireWidgetController('standard/input/FormInput');
//   
//   class CustomTextInput extends FormInput
//   {
//       function __construct()
//       {
//           parent::__construct();
//           $this->attrs['always_show_mask'] = new Attribute(getMessage(ALWAYS_SHOW_MASK_LBL), 'BOOL', getMessage(SET_TRUE_FLD_MASK_VAL_EXPECTED_MSG), false);
//           $this->attrs['always_show'] = new Attribute("always show field", 'BOOL', "always show the field", false);
//           $this->attrs['require_validation'] = new Attribute(getMessage(REQUIRE_VALIDATION_FIELD_LBL), 'BOOL', sprintf(getMessage(ST_TRUE_ADD_ADDTL_VALIDATION_FLD_MSG), 'password_verify'), false);
//           $this->attrs['label_validation_incorrect'] = new Attribute(getMessage(LABEL_VALIDATION_INCORRECT_LBL), 'STRING', getMessage(ERR_LABEL_DISP_VALIDATION_FLD_PRIM_MSG), getMessage(DOES_NOT_MATCH_PCT_S_LBL));
//           $this->attrs['label_validation'] = new Attribute(getMessage(LABEL_VALIDATION_LBL), 'STRING', getMessage(LABEL_DISPLAY_VALIDATION_FIELD_MSG), getMessage(RE_ENTER_PCT_S_LBL));
//           $this->attrs['hide_hint'] = new Attribute(getMessage(HIDE_HINT_CMD), 'BOOL', getMessage(SPECIFIES_HINTS_HIDDEN_DISPLAYED_MSG), false);
//           $this->attrs['maximum_length'] = new Attribute(getMessage(MAXIMUM_FIELD_LENGTH_LBL), 'INT', getMessage(RESTRICTION_MAX_CHARS_ALLOWED_MSG), 0);
//           $this->attrs['maximum_length']->min = 0;
//           $this->attrs['minimum_length'] = new Attribute(getMessage(MINIMUM_FIELD_LENGTH_LBL), 'INT', getMessage(RESTRICTION_MINIMUM_CHARS_ENTERED_MSG), 0);
//           $this->attrs['minimum_length']->min = 0;
//           $this->attrs['disable_password_autocomplete'] = new Attribute(getMessage(DISABLE_PASSWORD_AUTO_COMPLETE_CMD), 'BOOL', getMessage(PREVENT_BROWSER_AUTOCOMPLETION_MSG), false);    
//           $this->attrs['display_value'] = new Attribute("display value", 'STRING', "value to compare", "");
//           $this->attrs['hideon_notequal_value'] = new Attribute("hide when not equal value", 'STRING', "value to compare for hidding", "");
//           $this->attrs['hideon_value'] = new Attribute("hide when equal value", 'STRING', "value to compare for hidding", "");
//       }
//   
//       function generateWidgetInformation()
//       {
//           parent::generateWidgetInformation();
//           $this->info['notes'] =  getMessage(WDGT_ALLWS_USRS_SET_FLD_VALS_DB_MSG);
//       }
//   
//       function getData()
//       {
//           if(parent::retrieveAndInitializeData() === false)
//               return false;
//   
//           if($this->field->data_type !== EUF_DT_PASSWORD && $this->field->data_type !== EUF_DT_THREAD && $this->field->data_type !== EUF_DT_MEMO &&
//              $this->field->data_type !== EUF_DT_VARCHAR && $this->field->data_type !== EUF_DT_INT)
//           {
//               echo $this->reportError(sprintf(getMessage(PCT_S_TXT_INT_PASSWD_THREAD_MSG), $this->fieldName));
//               return false;
//           }
//   
//           if($this->data['js']['mask'] && $this->data['value'])
//               $this->data['value'] = $this->_addMask($this->data['value'], $this->data['js']['mask']);
//   
//           //Only set the max length off the attribute if it's less than the DB required max length
//           if($this->data['attrs']['maximum_length'] > 0){
//               $this->data['maxLength'] = ($this->data['maxLength'] > 0) ? min($this->data['maxLength'], $this->data['attrs']['maximum_length']) : $this->data['attrs']['maximum_length'];
//               $this->data['js']['fieldSize'] = $this->data['maxLength'];
//           }
//           //If a minimum length is set, that also means the user has to input some content, thereby making it required
//           if($this->data['attrs']['minimum_length'] > 0){
//               if($this->data['maxLength'] > 0 && ($this->data['attrs']['minimum_length'] > $this->data['maxLength'])){
//                   echo $this->reportError(sprintf(getMessage(FLD_PCT_S_MNIMUM_LNG_PCT_D_MAX_LNG_MSG), $this->fieldName, $this->data['attrs']['minimum_length'], $this->data['maxLength']));
//                   return false;
//               }
//               $this->data['attrs']['required'] = true;
//           }
//   
//           //Standard Field
//           if(!($this->field instanceof CustomField))
//           {
//               if($this->field->data_type === EUF_DT_PASSWORD)
//               {
//                   //honor config: don't output password fields
//                   if(!getConfig(EU_CUST_PASSWD_ENABLED)) return false;
//   
//                   redirectIfPageNeedsToBeSecure();
//   
//                   $this->data['value'] = '';
//                   $field = $this->field;
//                   $passwordValidations = $field::$validations;
//   
//                   $this->data['js']['passwordLength'] = $passwordValidations['length']['count'];
//                   if($this->data['js']['passwordLength'] > 0 && !in_array($this->fieldName, array('password', 'organization_password'), true))
//                       $this->data['attrs']['required'] = true;
//   
//                   if ($this->fieldName === 'password_new') {
//                       // Doesn't apply to current password, password_verify fields
//                       $validationsToPerform = array();
//                       foreach ($passwordValidations as $name => $validation) {
//                           if (!$validation['count'] || $name === 'old' || 
//                               (($name === 'repetitions' || $name === 'occurrences') && $validation['count'] > $this->data['js']['passwordLength'])) continue;
//                           // Only include validations with actual counts.
//                           // Don't validate against old passwords on the client.
//                           // Don't display confusing max-occurrences & max-repetitions if
//                           //  their requirement is greater than the required length
//                           $validationsToPerform[$name] = $validation;
//                       }
//                       if ($validationsToPerform) {
//                           $this->data['js']['passwordValidations'] = $validationsToPerform;
//                       }
//                   }
//               }
//               //Error if using alt first/last name fields when not on Japanese site
//               if(($this->fieldName === 'alt_first_name' || $this->fieldName === 'alt_last_name') && LANG_DIR !== 'ja_JP')
//               {
//                   echo $this->reportError(getMessage(ALT_FIRST_NAME_ALT_LAST_NAME_FLDS_MSG));
//                   return false;
//               }
//               //Prepopulate email address field if it is not set and it has been entered on a previous feedback
//               if($this->fieldName === 'email' && !$this->field->value && $this->CI->session->getSessionData('previouslySeenEmail'))
//                   $this->data['value'] = $this->CI->session->getSessionData('previouslySeenEmail');
//           }
//           $this->data['js']['contactToken'] = createToken(1);
//       }
//   
//        /**
//        * Creates and returns a mask string based upon the field's
//        * value.
//        * @param $value String the field's initial value
//        * @param $mask String the Mask value
//        * @return string the field's initial mask value
//        */
//        private static function _addMask($value, $mask)
//        {
//            $j = 0;
//            $result = '';
//            for($i = 0; $i < strlen($mask); $i+=2)
//            {
//                while($mask[$i] === 'F')
//                {
//                    $result .= $mask[$i + 1];
//                    $i+=2;
//                }
//                $result .= $value[$j];
//                $j++;
//            }
//            return $result;
//        }
//   }
//   
//   