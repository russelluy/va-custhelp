<?php /* Originating Release: November 2014 */

namespace Custom\Widgets\input;

use RightNow\Utils\Url,
    RightNow\Utils\Text;

class ProductCategoryInputCustom extends \RightNow\Libraries\Widget\Input
{
    const PRODUCT = 'Product';
    const CATEGORY = 'Category';

    function __construct($attrs)
    {
        parent::__construct($attrs);
    }

    function getData()
    {
        $dataType = $this->data['attrs']['data_type'] = (Text::stringContains(strtolower($this->data['attrs']['data_type']), 'prod'))
            ? self::PRODUCT
            : self::CATEGORY;

        if ($this->data['attrs']['data_type'] === self::CATEGORY) {
            $this->data['attrs']['label_all_values'] =
                ($this->data['attrs']['label_all_values'] === \RightNow\Utils\Config::getMessage(ALL_PRODUCTS_LBL))
                ? \RightNow\Utils\Config::getMessage(ALL_CATEGORIES_LBL)
                : $this->data['attrs']['label_all_values'];

            $this->data['attrs']['label_input'] =
                ($this->data['attrs']['label_input'] === \RightNow\Utils\Config::getMessage(PRODUCT_LBL))
                ? \RightNow\Utils\Config::getMessage(CATEGORY_LBL)
                : $this->data['attrs']['label_input'];

            $this->data['attrs']['label_nothing_selected'] =
                ($this->data['attrs']['label_nothing_selected'] === \RightNow\Utils\Config::getMessage(SELECT_A_PRODUCT_LBL))
                ? \RightNow\Utils\Config::getMessage(SELECT_A_CATEGORY_LBL)
                : $this->data['attrs']['label_nothing_selected'];
        }

        if ($this->data['attrs']['table'] === 'contacts') {
            echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(PCT_S_SUPP_VALUE_PCT_S_ATTRIB_MSG), 'contacts', 'table'));
            return false;
        }
        $this->data['js']['name'] = $this->data['attrs']['name'] = "Incident.{$this->data['attrs']['data_type']}";

        if (parent::getData() === false) return false;

        if (!in_array($this->dataType, array('ServiceProduct', 'ServiceCategory'))) {
            echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(DATA_TYPE_PCT_S_APPR_PROD_S_CAT_MSG), $this->fieldName));
            return false;
        }

        if($this->data['attrs']['required_lvl'] > $this->data['attrs']['max_lvl']) {
            echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(VAL_PCT_S_EXCEEDS_PCT_S_PCT_S_SET_MSG), "required_lvl", "max_lvl", "max_lvl", "required_lvl", $this->data['attrs']['required_lvl']));
            $this->data['attrs']['max_lvl'] = $this->data['attrs']['required_lvl'];
        }

        if($this->data['attrs']['hint'] && strlen(trim($this->data['attrs']['hint']))){
            $this->data['js']['hint'] = $this->data['attrs']['hint'];
        }

        $trimmedTreeViewCss = trim($this->data['attrs']['treeview_css']);
        if ($trimmedTreeViewCss !== '')
            $this->addStylesheet($trimmedTreeViewCss);

        $this->data['js']['linkingOn'] = $this->data['attrs']['linking_off'] ? 0 : $this->CI->model('Prodcat')->getLinkingMode();
        $this->data['js']['hm_type'] = ($dataType === self::PRODUCT) ? HM_PRODUCTS : HM_CATEGORIES;

        //Build up a tree of the default data set given a default chain. If there is not a default chain and linking
        //is off, just return the top level products or categories. If linking is on and this is the category
        //widget, return all of the linked categories.
        $maxLevel = $this->data['attrs']['max_lvl'];
        $defaultChain = $this->getDefaultChain();
        if($this->data['js']['linkingOn'] && $dataType === self::CATEGORY) {
            $defaultProductID = $this->CI->model('Prodcat')->getDefaultProductID() ?: null;
            $this->data['js']['link_map'] = $defaultHierMap = $this->CI->model('Prodcat')->getFormattedTree($dataType, $defaultChain, true, $defaultProductID, $maxLevel)->result;
            $this->data['js']['hierDataNone'] = $this->CI->model('Prodcat')->getFormattedTree($dataType, array(), true, null, $maxLevel)->result;
            array_unshift($this->data['js']['hierDataNone'][0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
            array_unshift($this->data['js']['link_map'][0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
        }
        else {
            if($dataType === self::PRODUCT) {
                $this->CI->model('Prodcat')->setDefaultProductID(end($defaultChain));
            }
            $defaultHierMap = $this->CI->model('Prodcat')->getFormattedTree($dataType, $defaultChain, false, null, $maxLevel)->result;
        }

        //Add in the all values label
        array_unshift($defaultHierMap[0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
        $this->data['js']['hierData'] = $defaultHierMap;
    }

    /**
    * Retrieves defaults with the following priority:
    * 1) old-school POST parameter (e.g. 'p')
    * 2) new-school POST parameter (e.g. 'incidents_prod')
    * 3) new-new-school POST parameter (e.g. 'Incident_Product')
    * 4) from the product or category data of an incident
    * 5) old-school URL parameter (e.g. 'p', 'c')
    * 6) new-school URL parameter (e.g. incidents.prod)
    * 7) new-new-school URL parameter (e.g. Incident.Product) (yep.)
    * 8) default_value attribute
    * @return Array The default chain chosen from the above options. If no chain is found, returns an empty array.
    */
    protected function getDefaultChain() {
        $dataType = $this->data['attrs']['data_type'];
        $shortDataType = ($dataType === self::PRODUCT) ? 'prod' : 'cat';
        $defaultValue = null;

        $postKeys = array(
            "Incident_$dataType",
            "incidents_$shortDataType",
            $shortDataType[0],
        );
        $urlKeys = array(
            "Incident.$dataType",
            "incidents.$shortDataType",
            $shortDataType[0],
        );

        // look for a value in the the post vars. Generally only used by basic pageset
        foreach ($postKeys as $key) {
            $postParam = $this->CI->input->post($key);
            if ($postParam !== false) {
                $defaultValue = $postParam;
            }
        }

        // look for a value in the incident data
        $incidentID = Url::getParameter('i_id');
        if (($defaultValue === false || $defaultValue === null) &&
            $incidentID && $incident = $this->CI->model('Incident')->get($incidentID)->result) {
            $incidentValue = $incident->{$dataType}->ID;
            if ($incidentValue) {
                $defaultValue = $incidentValue;
            }
        }

        // look for a value in the url params
        if ($defaultValue === false || $defaultValue === null) {
            foreach ($urlKeys as $key) {
                $urlParam = Url::getParameter($key);
                if ($urlParam !== null) {
                    $defaultValue = $urlParam;
                }
            }
        }

        // look for a value in the widget attributes
        if ($defaultValue === false || $defaultValue === null) {
            $defaultFromAttribute = $this->data['attrs']['default_value'];
            if ($defaultFromAttribute !== false) {
                $defaultValue = $defaultFromAttribute;
            }
        }

        //If the given value is only one ID long then it may be the last ID in a chain.
        //Attempt to get the full chain. If a full chain is given, trust that it is correct and get
        //the end user visible portion of it.
        if($defaultValue) {
            $defaultChain = explode(',', $defaultValue);
            $defaultChain = (count($defaultChain) === 1)
                                ? $this->CI->model('Prodcat')->getFormattedChain($dataType, $defaultChain[0], true)->result
                                : $this->CI->model('Prodcat')->getEnduserVisibleHierarchy($defaultChain)->result;
            if(count($defaultChain) > $this->data['attrs']['max_lvl']) {
                $defaultChain = array_splice($defaultChain, 0, $this->data['attrs']['max_lvl']);
            }
        }
        return $defaultChain ?: array();
    }
}
