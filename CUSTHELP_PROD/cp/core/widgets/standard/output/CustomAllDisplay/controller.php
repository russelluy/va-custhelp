<?php /* Originating Release: November 2014 */

namespace RightNow\Widgets;

class CustomAllDisplay extends CustomAllInput
{
    function __construct($attrs)
    {
        parent::__construct($attrs);
        $this->widgetType = 'output';
    }
}
