<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class BasicSelectionInput extends \RightNow\Widgets\SelectionInput {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        if(parent::getData() === false) {
            return false;
        }
    }
}