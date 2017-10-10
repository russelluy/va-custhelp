<?php
namespace Custom\Widgets\util;

class CustomInfoButton extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
          parent::__construct();
  
        /*  $this->attrs['report_id'] = new Attribute(getMessage(REPORT_ID_LBL), 'INT', getMessage(ID_RPT_DISP_DATA_SEARCH_RESULTS_MSG), CP_NOV09_ANSWERS_DEFAULT);
          $this->attrs['report_id']->min = 1;
          $this->attrs['report_id']->optlistId = OPTL_CURR_INTF_PUBLIC_REPORTS;
          $this->attrs['label_button'] = new Attribute(getMessage(BUTTON_LABEL_LBL), 'STRING', getMessage(STRING_LABEL_DISP_BTN_ICON_PATH_SET_MSG), getMessage(SEARCH_CMD));
          $this->attrs['target'] = new Attribute("Target Page URL", 'STRING', 'page url to navigate to', '');
          //$this->attrs['target'] = new Attribute(getMessage(TARGET_LBL), 'STRING', getMessage(DETERMINES_PG_TARG_RPT_PG_URL_MSG), '_self');
          $this->attrs['is_link'] = new Attribute("Is a Link", 'BOOL', "specifies if click action navigates to link", true);
          $this->attrs['new_window'] = new Attribute("Open in new window", 'BOOL', "specifies if link content opens in new browser window", true);
          $this->attrs['icon_path'] = new Attribute(getMessage(ICON_PATH_LBL), 'STRING', getMessage(LOCATION_IMAGE_FILE_SEARCH_ICON_LBL), false);
          $this->attrs['icon_alt_text'] = new Attribute(getMessage(ALTERNATIVE_TEXT_MSG), 'STRING', getMessage(TEXT_DISPLAYED_IMAGE_AVAILABLE_MSG), getMessage(SEARCH_CMD));
          $this->attrs['popup_window'] = new Attribute(getMessage(POPUP_WINDOW_LABEL_LBL), 'BOOL', getMessage(SPECIFIES_DISP_RES_POPUP_WINDOW_SET_LBL), false);
          $this->attrs['popup_window_width_percent'] = new Attribute(getMessage(POPUP_WINDOW_WIDTH_PERCENT_LABEL_LBL), 'INT', getMessage(SPECIFIES_WIDTH_POPUP_WINDOW_PCT_MSG), '30');
          $this->attrs['popup_window_height_percent'] = new Attribute(getMessage(POPUP_WINDOW_HEIGHT_PERCENT_LABEL_LBL), 'INT', getMessage(SPECIFIES_HEIGHT_POPUP_WINDOW_PCT_MSG), '42');
        */
  }
  
      function generateWidgetInformation()
      {
          $this->info['notes'] =  getMessage(WIDGET_DISP_BTN_IMG_LINK_SEARCHES_MSG);
      }
  
      function getData()
      {
          if($this->CI->agent->browser() === 'Internet Explorer')
              $this->data['isIE'] = true;
      }
}


?>