<?php /* Originating Release: November 2014 */

namespace RightNow\Widgets;

class SocialBookmarkLink extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        $pageTitle = \RightNow\Libraries\SEO::getDynamicTitle('answer', \RightNow\Utils\Url::getParameter('a_id'));
        $pageTitle = urlencode(htmlspecialchars_decode($pageTitle));

        $pageUrl = \RightNow\Utils\Url::getShortEufBaseUrl('sameAsCurrentPage', '/app/' . $this->CI->page . '/a_id/' . \RightNow\Utils\Url::getParameter('a_id'));

        $this->data['sites'] = array();
        $pages = explode(',', $this->data['attrs']['sites']);
        foreach($pages as $page) {
            list($name, $title, $link) = explode('>', trim($page, ' "\''));
            $link = str_replace('|URL|', $pageUrl, $link);
            $link = str_replace('|TITLE|', $pageTitle, $link);
            $this->data['sites'] []= array('name' => trim($name, '"\''), 'title' => trim($title, '"\''), 'link' => trim($link, '"\''));
        }
        if(!count($this->data['sites'])) return false;
    }
}