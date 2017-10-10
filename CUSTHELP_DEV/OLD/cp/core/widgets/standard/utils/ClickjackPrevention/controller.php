<?php /* Originating Release: November 2014 */

namespace RightNow\Widgets;

class ClickjackPrevention extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        header("X-Frame-Options:DENY");
    }
}


