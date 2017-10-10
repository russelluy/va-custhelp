<?php
namespace Custom\Widgets\input;

class custom_smartAssist extends \RightNow\Widgets\SmartAssistantDialog {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {

        $defaultButtons = array('label_solved_button', 'label_submit_button', 'label_cancel_button');
        $cleanUpValue = function($value) {
            return strtolower(trim($value));
        };
        $buttons = array_map($cleanUpValue, array_unique(explode(',', $this->data['attrs']['button_ordering'])));
        $displayAsLinks = array_map($cleanUpValue, array_unique(explode(',', $this->data['attrs']['display_button_as_link'])));
        $ordering = array();

        for($i = 0; $i < count($buttons); $i++) {
            if(($button = $buttons[$i]) && in_array($button, $defaultButtons) && $this->data['attrs'][$button]) {
                unset($defaultButtons[array_search($button, $defaultButtons, true)]);
                $this->pushItem($ordering, $button, in_array($button, $displayAsLinks));
            }
        }
        $i = 0;
        while(count($ordering) < count($defaultButtons) && $i < count($defaultButtons)) {
            $default = $defaultButtons[$i];
            if(!array_key_exists($default, $ordering) && $this->data['attrs'][$default]) {
                $this->pushItem($ordering, $default, in_array($default, $displayAsLinks));
            }
            $i++;
        }
        $this->data['attrs']['button_ordering'] = $ordering;

    }

    /**
     * Overridable methods from SmartAssistantDialog:
     */
    // function($value)
    // protected function pushItem(array &$orderingArray, $attributeName, $displayAsLink)
}