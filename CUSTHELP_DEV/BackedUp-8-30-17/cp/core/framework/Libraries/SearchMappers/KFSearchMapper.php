<?

namespace RightNow\Libraries\SearchMappers;

use RightNow\Utils\Url,
    RightNow\Utils\Config,
    RightNow\Libraries\SearchResult,
    RightNow\Libraries\SearchResults;

/**
 * Maps KFAPI search results into SearchResults.
 */
class KFSearchMapper extends BaseMapper {
    /**
     * Type of search
     */
    public static $type = 'KFSearch';

    /**
     * Maps Knowledge Foundation results to generic search source results
     * @param object $apiResult KF results from the KFAPI
     * @param array $filters Any filters to apply
     * @return SearchResults Generic serouce source results
     */
    static function toSearchResults ($apiResult, array $filters = array()) {
        if (!is_object($apiResult) || !property_exists($apiResult, 'SummaryContents')) return self::noResults($filters);

        $resultSet = new SearchResults();
        $resultSet->query = $query;
        $resultSet->size = $apiResult->TotalResults ? count($apiResult->SummaryContents) : 0;
        $resultSet->total = $apiResult->TotalResults;
        $resultSet->filters = $filters;
        $resultSet->offset = $filters['offset']['value'];

        if ($apiResult->TotalResults > 0 && $apiResult->SummaryContents) {
            foreach ($apiResult->SummaryContents as $summaryContent) {
                $result = new SearchResult();
                $result->type = self::$type;
                $result->url = $summaryContent->URL ?: self::defaultAnswerUrl($summaryContent->ID);
                $result->text = $summaryContent->Title;
                $result->summary = $summaryContent->Excerpt;
                $result->KFSearch->id = $summaryContent->ID;
                $result->updated = $summaryContent->UpdatedTime;

                $resultSet->results []= $result;
            }
        }

        return $resultSet;
    }

    /**
    * Creates default answer Url out of a given answer ID
    * @param int $id Answer ID
    * @return string Relative Url to answer
    */
    private static function defaultAnswerUrl ($id) {
        static $prefix;
        if (!$prefix) {
            $prefix = '/app/' . Config::getConfig(CP_ANSWERS_DETAIL_URL) . '/a_id/';
        }

        return $prefix . $id . Url::sessionParameter();
    }
}
