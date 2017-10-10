<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

class RecentSearches extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        if (!$this->helper('Okcs')->checkOkcsEnabledFlag($this->getPath()) || !($this->CI->session->canSetSessionCookies())) {
            return false;
        }
        
        $recentSearches = $this->CI->model('Okcs')->getUpdatedRecentSearches($this->data['attrs']['no_of_suggestions']);
        $this->data['js']['recentSearches'] = $recentSearches;
    }
}