<?

namespace RightNow\Libraries\SearchMappers;

use RightNow\Libraries\SearchResult,
    RightNow\Libraries\SearchResults;

/**
 * Interface for mapping source data into search results.
 */
interface BaseMapperInterface {
    /**
     * Maps results from disparate sources into search results
     * conforming to the RightNow\Libraries\SearchResult
     * interface.
     * @param  mixed $searchResults Raw data structures from disparate
     *                              sources containing result data
     * @param  array  $filters       Search filters used to trigger the search
     * @return object \RightNow\Libraries\SearchResults SearchResults instance
     */
    static function toSearchResults($searchResults, array $filters = array());
}

/**
 * Base class for mapping source data into search results.
 */
class BaseMapper implements BaseMapperInterface {
    public static $type = 'GenericSearchResult';

    /**
     * Should be implemented by children.
     * @param  mixed $searchResult Raw data structures from disparate
     *      sources containing result data
     * @param array $filters Search filters used to trigger the search
     */
    static function toSearchResults ($searchResult, array $filters = array()) {}

    /**
     * Returns an empty result set.
     * @param array $filters Search filters used to trigger the search
     * @return object \RightNow\Libraries\SearchResults Empty SearchResults instance
     */
    static function noResults (array $filters = array()) {
        return SearchResults::emptyResults($filters);
    }
}
