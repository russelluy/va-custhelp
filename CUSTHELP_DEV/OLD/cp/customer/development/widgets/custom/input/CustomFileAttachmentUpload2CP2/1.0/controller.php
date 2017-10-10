<?php
namespace Custom\Widgets\input;

class CustomFileAttachmentUpload2 extends \RightNow\Libraries\Widget\Base {
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
//   class CustomFileAttachmentUpload2 extends Widget
//   {
//       function __construct()
//       {
//           parent::__construct();
//           $this->attrs['label_input'] = new Attribute(getMessage(INPUT_LABEL_LBL), 'STRING', getMessage(LABEL_DISPLAY_INPUT_CONTROL_LBL), getMessage(ATTACH_DOCUMENTS_LBL));
//           $this->attrs['label_error'] = new Attribute(getMessage(ERROR_LABEL_LBL), 'STRING', sprintf(getMessage(PCT_S_IDENTIFY_FLD_NAME_ERR_MSGS_MSG), 'label_input'), '');
//           $this->attrs['label_remove'] = new Attribute(getMessage(REMOVE_ATTACHMENT_LABEL_CMD), 'STRING', getMessage(LABEL_DISPLAY_LINK_REMOVE_ATTACH_LBL), getMessage(REMOVE_CMD));
//           $this->attrs['always_show'] = new Attribute("always show field", 'BOOL', "always show the field", false);
//           $this->attrs['max_attachments'] = new Attribute(getMessage(MAXIMUM_ATTACHMENTS_LBL), 'INT', getMessage(SPECIFIES_ATTACHMENTS_UPLOAD_SNGL_MSG), 0);
//           $this->attrs['label_max_attachment_limit'] = new Attribute(getMessage(MAX_ATTACHMENT_LIMIT_LABEL_LBL), 'STRING', getMessage(ERR_MSG_DISP_REACHES_UPLOAD_LIMIT_LBL), getMessage(REACHD_LIMIT_FILES_UPLOADED_ADD_MSG));
//           $this->attrs['label_generic_error'] = new Attribute(getMessage(GENERIC_ERROR_MESSAGE_LBL), 'STRING', getMessage(GENERIC_ERR_DISP_UNKNOWN_ERR_MSG), getMessage(FILE_SUCC_UPLOADED_FILE_PATH_FILE_MSG));
//           $this->attrs['loading_icon_path'] = new Attribute(getMessage(LOADING_ICON_PATH_LBL), 'STRING', getMessage(FILE_PATH_IMG_DISP_SUBMITTING_FORM_LBL), 'images/indicator.gif');
//           $this->attrs['min_required_attachments'] = new Attribute(getMessage(MINIMUM_REQUIRED_ATTACHMENTS_LBL), 'INT', getMessage(MINIMUM_REQD_ATTACHMENTS_LBL), 0);
//           $this->attrs['label_min_required'] = new Attribute(getMessage(MINIMUM_REQUIRED_LABEL_LBL), 'STRING', getMessage(ERR_MSG_DISP_MINIMUM_REQD_MSG), getMessage(PCT_S_REQUIRES_PCT_S_FILE_S_LBL));
//           $this->attrs['valid_file_extensions'] = new Attribute(getMessage(VALID_FILE_EXTENSIONS_LBL), 'STRING', getMessage(L_ACCD_FILE_EXTENSIONS_LEADING_MSG), '');
//           $this->attrs['label_invalid_extension'] = new Attribute(getMessage(LABEL_INVALID_FILE_EXTENSION_LBL), 'STRING', sprintf(getMessage(LABEL_INV_FILE_EXTENSION_PCT_S_LBL), 'valid_file_extensions'), getMessage(FOLLOWING_FILE_TYPES_ALLOWED_PCT_S_MSG));
//           $this->attrs['display_value'] = new Attribute("display value", 'STRING', "value to compare", "display value");
//       }
//   
//       function generateWidgetInformation()
//       {
//           $this->info['notes'] =  getMessage(WIDGET_ALLOWS_USERS_ATTACH_FILES_MSG);
//           $this->parms['i_id'] = new UrlParam(getMessage(INCIDENT_ID_LBL), 'i_id', false, getMessage(INCIDENT_ID_GET_INFORMATION_LBL), 'i_id/7');
//       }
//   
//       function getData()
//       {
//           //Check if incident already has max number of file attachments
//           $incidentID = getUrlParm('i_id');
//           if($incidentID)
//           {
//               $this->CI->load->model('standard/Incident_model');
//               $this->data['js']['attachmentCount'] = $this->CI->Incident_model->getFileAttachmentCount($incidentID);
//           }
//           
//           if($this->data['attrs']['max_attachments'] !== 0 && $this->data['attrs']['min_required_attachments'] > $this->data['attrs']['max_attachments'])
//           {
//               echo $this->reportError(sprintf(getMessage(PCT_S_PCT_S_LBL), 'min_required_attachments', 'max_attachments'));
//               return false;
//           }
//       }
//   }
//   
//   