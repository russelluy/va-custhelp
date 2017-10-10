<?php
namespace RightNow\Libraries;
use RightNow\Api,
    RightNow\Utils\Config;

/**
 * Static class for all Search Engine Optimization functions.
 */
class SEO
{
    private static $CI;

    /**
     * Gets the page title based on the answer or incident summary
     * @param string $type Answers or incidents
     * @param int $recordID The answer or incident ID
     * @return string The title of the answer or incident
     */
    public static function getDynamicTitle($type, $recordID)
    {
        if(!is_numeric($recordID))
        {
            if($type === 'answer')
            {
                return Config::getMessage(ANSWER_LBL);
            }
            if ($type === 'incident')
            {
                return Config::getMessage(VIEW_QUESTION_HDG);
            }
            if ($type === 'asset')
            {
                return Config::getMessage(VIEW_ASSET_CMD);
            }
        }

        $title = self::getRecordTitle($type, $recordID);
        return Api::print_text2str($title, OPT_STRIP_HTML_TAGS);
    }

    /**
     * Gets the 'title' of the supplied record. Titles may include answer summaries,
     * incident subjects, product or category names, etc..., and will be formatted
     * according to the rules of the supplied formatter. If the record is not found,
     * a reasonable generic title will be returned. Will use models when possible,
     * but may perform some DB queries.
     *
     * @param string $type The record type, either answers or incidents
     * @param int $recordID The unique identifier for the record
     * @return string The value of the record's 'title'
     * @throws \Exception If the $type is not recognized.
     */
    public static function getRecordTitle($type, $recordID)
    {
        if(!self::$CI)
            self::$CI = get_instance();

        if($type === 'answer')
        {
            $record = self::$CI->model('Answer')->get($recordID)->result;
            return ($record) ? $record->Summary : Config::getMessage(ANSWER_LBL);
        }
        if ($type === 'incident')
        {
            $record = self::$CI->model('Incident')->get($recordID)->result;
            return ($record) ? $record->Subject : Config::getMessage(VIEW_QUESTION_HDG);
        }
        if ($type === 'asset')
        {
            $record = self::$CI->model('Asset')->get($recordID)->result;
            return ($record) ? $record->Name : Config::getMessage(VIEW_ASSET_CMD);
        }
        // products and categories??
        throw new \Exception("Unknown record type: [$type]");
    }

    /**
     * Produces a URL that is "canonical" for the given answer. This URL will be of the form:
     *
     *      http://www.site.com/app/{CP_ANSWERS_DETAIL_URL}/a_id/{$answerID}/~/{title-of-answer}
     *
     * The title will be truncated to 80 multibyte characters (less if the truncation
     * cuts through a word). The individual words of the title will be separated by hyphens.
     * @param int $answerID The answer ID
     * @return string The canonical URL
     */
    public static function getCanonicalAnswerURL($answerID)
    {
        $title = self::getAnswerSummarySlug(self::getRecordTitle('answer', $answerID));

        return \RightNow\Utils\Url::getShortEufAppUrl('sameAsCurrentPage', Config::getConfig(CP_ANSWERS_DETAIL_URL)) . "/a_id/$answerID/~/$title";
    }

    /**
     * Convert an answer summary to a slug for use in canonical URLs
     * @param string $summary The answer summary
     * @return string          The slug
     */
    public static function getAnswerSummarySlug($summary) {
        // the maximum number of (multibyte) characters to take from the title
        $maxTitleLength = 80;
        $titleLength = 0;

        // In order to make sure the URL isn't TOO ugly, we trim it down
        try
        {
            $titleLength = \RightNow\Utils\Text::getMultibyteStringLength($summary);
        }
        catch (\Exception $e)
        {
            $summary = Api::utf8_cleanse($summary);

            try
            {
                $titleLength = \RightNow\Utils\Text::getMultibyteStringLength($summary);
            }
            catch (\Exception $e)
            {
                // I give up
                $summary = '';
            }
        }

        if ($titleLength > $maxTitleLength)
        {
            $summary = Api::utf8_trunc_nchars($summary, $maxTitleLength);

            // We have truncated to the max size, but we might have cut a word in
            // half. So, find the last space and truncate to there. If no space is
            // found (it's one big giant word), then don't truncate at all - in
            // order to safeguard Asian language titles.
            if (($pos = strrpos($summary, ' ')) !== false){
                $summary = substr($summary, 0, $pos);
            }
        }

        // IE sees certain character combinations with quotes in cannonical links as XSS attacks, even when encoded.
        $summary = str_replace(array('\'', '"'), '', strtolower($summary));
        // Google recommends using hyphens instead of spaces or underscores
        $summary = preg_replace('/\s+/', '-', $summary);
        // Don't forget to URL-encode the text
        $summary = urlencode($summary);

        return $summary;
    }

    /**
     * Produces a meta tag that will be used by internet spiders to know
     * what URL to associate the page content with. Uses getCanonicalAnswerURL()
     * @return string A ready to print (in the head section) canonical directive
     */
    public static function getCanonicalLinkTag()
    {
        if(!self::$CI)
            self::$CI = get_instance();

        // Right now, only output something if this is the answer detail page
        // In the future, add support for other pages.
        if (self::$CI->page === Config::getConfig(CP_ANSWERS_DETAIL_URL))
        {
            if ($answerID = \RightNow\Utils\Url::getParameter('a_id'))
            {
                $href = self::getCanonicalAnswerURL($answerID);
                return "<link rel='canonical' href='$href'/>";
            }
        }
        return null;
    }

    /**
     * Sets up the class to use a mock controller instead of the CP
     * standard one. Use SimpleTest's Mock class to generate the object.
     * New controller will override any previous controllers loaded.
     * Only useful for testing purposes (do NOT use in real code).
     * @param object $mockCI The mock controller.
     * @return void
     * @internal
     */
    public static function setMockController($mockCI)
    {
        self::$CI = $mockCI;
    }
}