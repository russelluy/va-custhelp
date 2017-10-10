<?php
namespace Custom\Widgets\input;
class CustomSelectionInput extends \RightNow\Widgets\SelectionInput {
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
return parent::getData();
}
}