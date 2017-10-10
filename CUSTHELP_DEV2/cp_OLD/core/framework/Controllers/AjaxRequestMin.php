<?php

namespace RightNow\Controllers;
use RightNow\Utils\Framework;

/**
 * Endpoints for minor data actions that aren't recorded as part of clickstreams
 */
final class AjaxRequestMin extends Base
{
    /**
     * Retrieve the children of the specified product or category.
     * Required GET or POST parameters: id, filter
     * Optional GET or POST parameters: linking (specify false if product-category linking is enabled on the site but this
     * request should ignore linking). Returns JSON-encoded results. Is always an array and results appear as the first item
     * in the array; link_map is present as a key if product-category linking is enabled.
     *
     *     [
     *         0        => array of results,
     *         link_map => array of linked categories (optional)
     *     ]
     */
    public function getHierValues()
    {
        $id = $this->input->request('id');
        $filter = $this->input->request('filter');
        $linking = $this->input->request('linking');
        $results = $this->model('Prodcat')->getDirectDescendants($filter, $id);
        $results->result = array($results->result ?: array());

        if (\RightNow\Utils\Text::beginsWithCaseInsensitive($filter, 'prod') && $this->model('Prodcat')->getLinkingMode() &&
            ($linking !== 'false' && $linking !== '0')) {
            $linkedCategories = ((int) $id === -1)
                // Product selection went back to 'All' -> retrieve all top-level categories
                ? array($this->model('Prodcat')->getDirectDescendants('Category')->result)
                : $this->model('Prodcat')->getLinkedCategories($id)->result;

            $results->result += array('link_map' => $linkedCategories ?: array(array())); // Don't ask.
        }

        Framework::sendCachedContentExpiresHeader();
        echo $results->toJson();
    }

    /**
     * Retrieve the children of the specified sales product. Requires an id and level GET or POST parameters.
     */
    public function getHierValuesForProductCatalog()
    {
        $results = $this->model('ProductCatalog')->getDirectDescendants($this->input->request('id'), $this->input->request('level'), $this->input->request('isSearchRequest'));
        $results->result = $results->result ?: array();
        Framework::sendCachedContentExpiresHeader();
        echo $results->toJson();
    }

    /**
     * Retrieves the full hierarchy of products or categories to display for accessible purposes.
     */
    public function getAccessibleTreeView()
    {
        $hmType = intval($this->input->request('hm_type'));
        $linkingOn = $this->input->request('linking_on');
        $results = $this->model('Prodcat')->getHierPopup($hmType, $linkingOn);
        Framework::sendCachedContentExpiresHeader();
        echo $results->toJson();
    }

    /**
     * Retrieves the full hierarchy of the product catalog to display for accessible purposes.
     */
    public function getAccessibleProductCatalogTreeView()
    {
        $isSearchRequest = $this->input->request('isSearchRequest');
        $results = $this->model('ProductCatalog')->getHierPopup($isSearchRequest);
        Framework::sendCachedContentExpiresHeader();
        echo $results->toJson();
    }

    /**
     * Provided the country ID, gets the list of provinces/states
     */
    public function getCountryValues()
    {
        $id = $this->input->request('country_id');
        $results = $this->model('Country')->get($id)->result;
        Framework::sendCachedContentExpiresHeader();
        if ($results) {
            // Kick the lazy loader for fields client needs
            $results->ProvincesLength = count($results->Provinces);
            if(\RightNow\Utils\Connect::isArray($results->Provinces)){
                foreach ($results->Provinces as $province) {
                    $province->ID; $province->DisplayOrder; $province->Name;
                }
            }
            $results->PostalMask; $results->PhoneMask;
        }
        echo json_encode($results);
    }
}
