<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class MobileEmailAnswerLink extends \RightNow\Widgets\EmailAnswerLink {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(WDGT_DPRCTED_PCT_S_RELEASE_MSG), "November '12"), false);
        return parent::getData();
    }
}
