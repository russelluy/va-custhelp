<?php /* Originating Release: August 2012 */

  if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!class_exists('FormInput'))
    requireWidgetController('standard/input/FormInput');


class ToggleVisibleArea extends Widget 
{
    function __construct()
    {
        parent::__construct();
        $this->info ['type'] = 'blank';

        $this->attrs['label'] = new Attribute("label value", 'STRING', "label value", "label value");
        $this->attrs['display_value'] = new Attribute("display value", 'STRING', "value to compare", "display value");
        $this->attrs['toggle_div_name'] = new Attribute("toggle div name", 'STRING', "name of div", "toggle div name");
        $this->attrs['hideon_notequal_value'] = new Attribute("hide when not equal value", 'STRING', "value to compare for hidding", "hide when not equal value");
    }

    function generateWidgetInformation()
    {
        $this->info['notes'] =  getMessage(WIDGET_BLANK_CONTROLLER_SPECIFIC_MSG);
    }

    function getData()
    {
      

    }

}

