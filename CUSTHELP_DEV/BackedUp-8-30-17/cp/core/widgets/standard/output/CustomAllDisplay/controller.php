<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class CustomAllDisplay extends CustomAllInput
{
    function __construct($attrs)
    {
        parent::__construct($attrs);
        $this->widgetType = 'output';
    }
}
