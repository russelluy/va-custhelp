<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class ClickjackPrevention extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        header("X-Frame-Options: " . $this->data['attrs']['frame_options']);
    }
}
