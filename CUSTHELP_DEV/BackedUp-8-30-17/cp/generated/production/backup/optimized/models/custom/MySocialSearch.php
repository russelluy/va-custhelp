<?php
namespace Custom\Models;
use RightNow\Libraries\SearchMappers\SocialSearchMapper;
require_once CPCORE . 'Models/SocialSearch.php';
class MySocialSearch extends \RightNow\Models\SocialSearch {
function __construct() {
parent::__construct();
}
function search(array $filters = array()) {
return parent::search($filters);
}
}
