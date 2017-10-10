<?

namespace RightNow\Helpers;

use RightNow\Utils\Text;

class RecentlyViewedContentHelper extends \RightNow\Libraries\Widget\Helper {
    protected $contentTypes = array(
        'SocialQuestion' => array(
            'title' => 'Subject',
        ),
        'AnswerContent' => array(
            'title' => 'Summary',
        ),
    );

    /**
     * Returns the title of the Social Question or KB Answer properly truncated and escaped
     * @param object $content Answer/SocialQuestion object
     * @param int $limit Truncation character limit
     * @return string|null Object title
     */
    function getTitle($content, $limit) {
        $contentType = $this->getContentType($content);

        if(!$contentType) {
            return null;
        }

        $titleType = $this->contentTypes[$this->getContentType($content)]['title'];
        $title = Text::escapeHtml($content->$titleType, false);

        if ($limit) {
            $title = Text::truncateText($title, $limit, true, 40);
        }

        return $title;
    }

    /**
    * Returns the type of content being used
    * @param object $content Answer/SocialQuestion object to evaluate
    * @return string|null Type of Object: Either SocialQuestion or AnswerContent
    */
    function getContentType($content) {
        foreach(array_keys($this->contentTypes) as $type) {
            if(Text::stringContains(get_class($content), $type)) {
                return $type;
            }
        }
    }
}