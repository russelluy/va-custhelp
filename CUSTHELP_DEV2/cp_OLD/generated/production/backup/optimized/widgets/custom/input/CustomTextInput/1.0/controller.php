<?php
namespace Custom\Widgets\input;
class CustomTextInput extends \RightNow\Widgets\TextInput {
function __construct($attrs) {
parent::__construct($attrs);
}
function getData() {
return parent::getData();
}
}