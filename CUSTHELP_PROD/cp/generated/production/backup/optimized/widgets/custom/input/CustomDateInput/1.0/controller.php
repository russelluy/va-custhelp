<?php
namespace Custom\Widgets\input;
class CustomDateInput extends \RightNow\Widgets\DateInput {
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
return parent::getData();
}
}