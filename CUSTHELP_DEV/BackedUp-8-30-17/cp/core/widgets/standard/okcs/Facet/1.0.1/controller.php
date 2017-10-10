<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

use RightNow\Utils\Config,
    RightNow\Libraries\Search,
    RightNow\Utils\Url;

class Facet extends \RightNow\Libraries\Widget\Base {
    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        if (!(Config::getConfig(OKCS_ENABLED))) {
            echo $this->reportError(\RightNow\Utils\Config::getMessage(THE_OKCSENABLED_CFG_SET_MUST_BE_MSG));
            return false;
        }

        if ($this->sourceError()) return false;

        $search = Search::getInstance($this->data['attrs']['source_id']);
        $filters = array('truncate' => array('value' => $this->data['attrs']['truncate_size']));
        if (!is_null(Url::getParameter('searchType')))
            $filters['searchType'] = array('value' => Url::getParameter('searchType'));
        $facets = $search->addFilters($filters)->executeSearch()->searchResults['results']->facets;
        $filter = $search->getFilters();

        if ($facets !== null) {
            foreach ($facets as $facetItem) {
                if ($facetItem->children === null) {
                    echo $this->reportError(Config::getMessage(RES_OBJECT_PROPERTY_CHILDREN_IS_NOT_MSG));
                    return false;
                }
                if ($facetItem->id === null) {
                    echo $this->reportError(Config::getMessage(RES_OBJECT_PROPERTY_ID_IS_NOT_MSG));
                    return false;
                }
                if ($facetItem->desc === null) {
                    echo $this->reportError(Config::getMessage(RES_OBJECT_PROPERTY_DESC_IS_NOT_MSG));
                    return false;
                }
                if ($facetItem->inEffect === null) {
                    echo $this->reportError(Config::getMessage(RES_OBJECT_PROPERTY_INEFFECT_IS_NOT_MSG));
                    return false;
                }
            }
        }

        $this->data['facets'] = $facets;

        if ($filter) {
            $this->data['js'] = array(
                'filter'  => $filter,
                'sources' => $search->getSources(),
                'facets'  => json_encode($facets)
            );
        }
        if ($this->data['attrs']['hide_when_no_results'] && !$this->data['results']->total) {
            $this->classList->add('rn_Hidden');
        }
    }

    /**
    * Renders current facet.
    * @param object $currentFacet Current facet
    * @param boolean $hasChildren True if current facet has children False if no children for current facet
    */
    function processChildren($currentFacet, $hasChildren) {
        echo $this->render('facetLink',
            array(
                'facetID' => $currentFacet->id,
                'description' => $currentFacet->desc,
                'facetClass' => $currentFacet->inEffect ? 'rn_FacetLink rn_ActiveFacet' : 'rn_FacetLink',
                'hasChildren' => $hasChildren
            )
        );
    }

    /**
    * Checks children of the current facet recursively. Process current facet if no children found.
    * @param object $facet Current facet
    * @param object $parentLi Parent list node
    * @param int $maxSubFacetSize Number of facets to be displayed
    */
    function findChildren($facet, $parentLi, $maxSubFacetSize) {
        $length = count($facet->children);
        $displayFacetLength = $maxSubFacetSize;
        if ($maxSubFacetSize !== null && $maxSubFacetSize > 0 && $length > $maxSubFacetSize)
            $displayFacetLength = $maxSubFacetSize;
        for ($i = 0; $i < $displayFacetLength; ++$i) {
            $currentFacet = $facet->children[$i];
            if ($currentFacet !== null) {
                if (count($currentFacet->children) !== 0) {
                    $this->processChildren($currentFacet, true);
                    echo $this->render('facetIndent',
                        array(
                            'facetID' => $currentFacet->id,
                            'startListIndent' => true
                        )
                    );
                    
                    $this->findChildren($currentFacet, $parentLi, $maxSubFacetSize);
                }
                else {
                    $this->processChildren($currentFacet, false);
                    if($i === ($displayFacetLength - 1)) {
                        echo $this->render('facetIndent',
                            array(
                                'startListIndent' => false
                            )
                        );
                    }
                }
            }
        }
        if ($maxSubFacetSize != null && $maxSubFacetSize > 0 && $length > $maxSubFacetSize)
            echo $this->render('morelink', array('facetID' => $currentFacet->id, 'description' => $currentFacet->desc));
    }

    /**
     * Checks for a source_id error. Emits an error message if a problem is found.
     * @return boolean True if an error was encountered False if all is good
    */
    private function sourceError () {
        if (\RightNow\Utils\Text::stringContains($this->data['attrs']['source_id'], ',')) {
            echo $this->reportError(Config::getMessage(THIS_WIDGET_ONLY_SUPPORTS_A_SNGL_I_UHK));
            return true;
        }
        return false;
    }
}
