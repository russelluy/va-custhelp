<?php
namespace Custom\Widgets\display;

class CustomInfoButton extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {

        if($this->CI->agent->browser() === 'Internet Explorer')
               $this->data['isIE'] = true;
               
        return parent::getData();
        
    }
}