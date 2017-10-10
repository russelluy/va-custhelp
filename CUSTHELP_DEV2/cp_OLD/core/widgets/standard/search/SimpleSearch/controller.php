<?php /* Originating Release: November 2014 */

namespace RightNow\Widgets;

class SimpleSearch extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        if($this->data['attrs']['report_page_url'] === '')
            $this->data['attrs']['report_page_url'] = '/app/' . $this->CI->page;
        if($this->CI->agent->browser() === 'Internet Explorer')
            $this->data['isIE'] = true;
    }
}
