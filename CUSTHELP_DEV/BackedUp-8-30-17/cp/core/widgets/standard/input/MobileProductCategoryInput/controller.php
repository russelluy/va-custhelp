<?php /* Originating Release: May 2016 */

namespace RightNow\Widgets;

use Rightnow\Utils\Url,
    RightNow\Utils\Text;

class MobileProductCategoryInput extends \RightNow\Libraries\Widget\Input {
    const PRODUCT = 'Product';
    const CATEGORY = 'Category';

    function __construct($attrs) {
        parent::__construct($attrs);
    }

    function getData() {
        $dataType = $this->data['attrs']['data_type'] = (Text::stringContains(strtolower($this->data['attrs']['data_type']), 'prod'))
            ? self::PRODUCT
            : self::CATEGORY;

        // all of the label defaults are for products - if the filter type is category, see if
        // the labels have the product default value and replace them with the category default value
        // otherwise, the attribute values were modified and should persist
        if ($this->data['attrs']['data_type'] === self::CATEGORY)
        {
            $this->data['attrs']['label_all_values'] =
                ($this->data['attrs']['label_all_values'] === \RightNow\Utils\Config::getMessage(ALL_PRODUCTS_LBL))
                ? \RightNow\Utils\Config::getMessage(ALL_CATEGORIES_LBL)
                : $this->data['attrs']['label_all_values'];

            $this->data['attrs']['label_input'] =
                ($this->data['attrs']['label_input'] === \RightNow\Utils\Config::getMessage(PRODUCT_LBL))
                ? \RightNow\Utils\Config::getMessage(CATEGORY_LBL)
                : $this->data['attrs']['label_input'];

            $this->data['attrs']['label_prompt'] =
                ($this->data['attrs']['label_prompt'] === \RightNow\Utils\Config::getMessage(SELECT_A_PRODUCT_LBL))
                ? \RightNow\Utils\Config::getMessage(SELECT_A_CATEGORY_LBL)
                : $this->data['attrs']['label_prompt'];

            $this->data['attrs']['label_data_type'] =
                ($this->data['attrs']['label_data_type'] === \RightNow\Utils\Config::getMessage(PRODUCTS_LBL))
                ? \RightNow\Utils\Config::getMessage(CATEGORIES_LBL)
                : $this->data['attrs']['label_data_type'];
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

        $this->data['js']['linkingOn'] = $this->data['attrs']['linking_off'] ? 0 : $this->CI->model('Prodcat')->getLinkingMode();
        $this->data['firstLevel'] = array(); //only populated with the first-level items and only passed to the view

        //If there is a default chain for this widget, find it and create the top level array.
        $defaultChain = $this->getDefaultChain();
        if($this->data['js']['linkingOn'] && $dataType === self::CATEGORY) {
            $defaultProductID = $this->CI->model('Prodcat')->getDefaultProductID() ?: null;
            if ($defaultProductID) {
                // If this is the categories widget AND there's some pre-selected product(s) AND linking is on -> get prod linking defaults.
                $defaultSelection = $this->setProdLinkingDefaults($this->data['firstLevel'], $defaultProductID, $defaultChain);
            }
            else {
                // Otherwise just get the data normally.
                $defaultSelection = $this->setDefaults($this->data['firstLevel'], $defaultChain, $dataType);
            }
        }
        else {
            if($dataType === self::PRODUCT) {
                $this->CI->model('Prodcat')->setDefaultProductID(end($defaultChain));
            }
            $defaultSelection = $this->setDefaults($this->data['firstLevel'], $defaultChain, $dataType);
        }

        if ($defaultSelection) {
            $this->data['js']['initial'] = $defaultSelection;
            $label = '';
            foreach ($defaultSelection as $item) {
                $label .= $item['label'] . '<br>';
            }
        }
        else {
            $label = $this->data['attrs']['label_prompt'];
        }
        $this->data['promptLabel'] = $label;
        $this->data['js']['hm_type'] = ($dataType === self::PRODUCT) ? HM_PRODUCTS : HM_CATEGORIES;

        //If there are no products or categories either don't render the widget at all, or if it's possible that it will display later, just hide it.

        if(empty($this->data['firstLevel'])) {
            if($this->data['js']['linkingOn'] && $dataType === self::CATEGORY) {
                $this->classList->add('rn_HideEmpty');
            }
            else {
                return false;
            }
        }
    }

    /**
    * Retrieves defaults with the following priority:
    * 1) from the product or category data of an incident
    * 2) new-school POST parameter (e.g. 'incidents.prod')
    * 3) new-new-school POST parameter (e.g. 'Incident.Product')
    * 4) old-school URL parameter (e.g. 'p', 'c')
    * 5) new-school URL parameter (e.g. incidents.prod)
    * 6) new-new-school URL parameter (e.g. Incident.Product) (yep.)
    * 7) default_value attribute
    * @return array The default chain chosen from the above options. If no chain is found, returns an empty array.
    */
    protected function getDefaultChain() {
        //Attempt to find a default value in one of the 7 different areas.
        $dataType = $this->data['attrs']['data_type'];
        if(($incidentID = Url::getParameter('i_id')) && ($incident = $this->CI->model('Incident')->get($incidentID)->result)) {
            $defaultValue = $incident->{$dataType}->ID;
        }
        if(!$defaultValue) {
            $order = array(
                // PHP replaces dots in POST parameter names with underscores, so look for that syntax
                array('name' => "incidents_" . (($dataType === self::PRODUCT) ? 'prod' : 'cat'), 'post' => true),
                array('name' => "Incident_{$dataType}", 'post' => true),
                array('name' => strtolower($dataType[0])),
                array('name' => "incidents." . (($dataType === self::PRODUCT) ? 'prod' : 'cat')),
                array('name' => "Incident.$dataType"),
            );
            foreach ($order as $prefill) {
                $defaultValue = ($prefill['post'])
                    ? $this->CI->input->post($prefill['name'])
                    : Url::getParameter($prefill['name']);

                if ($defaultValue) break;
            }
            $defaultValue || ($defaultValue = $this->data['attrs']['default_value']);
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

    /**
     * Utility function to retrieve hier menus and massage
     * the data for our usage.
     * @param array|null &$firstLevelItems To be populated with the first-level of items
     * @param array|null $hierItems List of hier menu IDs
     * @param string $dataType Name of data type (either products or categories)
     * @return array Populated array containing the pre-selected items
     */
    protected function setDefaults(&$firstLevelItems, $hierItems, $dataType) {
        $selection = array(); //populated list of what items are already chosen via URL parameter values
        $model = $this->CI->model('Prodcat');
        if ($hierItems) {
            // Get the hierarchy chain for the specified ids.
            $lastItem = end($hierItems);
            $selection = $model->getFormattedChain($dataType, $lastItem)->result;
        }
        if (!$firstLevelItems = $model->getDirectDescendants($dataType)->result) {
            return false;
        }

        if ($selection) {
            $firstLevelSelectedItem = $selection[0]['id'];
            foreach ($firstLevelItems as &$item) {
                if ($item['id'] == $firstLevelSelectedItem) {
                    $item['selected'] = true;
                    $selection[0] = array_merge($selection[0], $item);
                    break;
                }
            }
        }

        //add an additional 'no value' node to the front
        array_unshift($firstLevelItems, array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));

        return $selection;
    }

    /**
     * Utility function to retrieve hier menus for prod linking
     * and massage the data for our usage.
     * @param array|null &$firstLevelItems To be populated with the first-level of items
     * @param int $productID The previously selected product ID
     * @param array|null $catArray List of category hier menu IDs
     * @return array Populated array containing the pre-selected items
     */
    protected function setProdLinkingDefaults(&$firstLevelItems, $productID, $catArray) {
        if (!($hierArray = $this->CI->model('Prodcat')->getLinkedCategories($productID)->result))
            return false;
        ksort($hierArray);

        $matchIndex = 0;
        $hierList = '';
        $selection = array(); //Populate with the URL pre-selected categories
        foreach($hierArray as $parentID => $child) {
            if(!count($child)) {
                //for some reason there's empty arrays floating around...
                unset($hierArray[$parentID]);
                continue;
            }
            foreach($child as $dataArray) {
                $id = $dataArray['id'];
                if($id === intval($catArray[$matchIndex])) {
                    $selected = true;
                    $matchIndex++;
                    $hierList .= $id;
                    $selection []= $dataArray + array('hierList' => $hierList);
                    $hierList .= ',';
                }
                else {
                    $selected = false;
                }
                if($parentID === 0) {
                    //only want to pass first-level items to the view
                    $firstLevelItems []= $dataArray + array('selected' => $selected);
                }
            }
        }

        //add an additional 'no value' node to the front
        array_unshift($firstLevelItems, array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
        $this->data['js']['linkMap'] = $hierArray;
        return $selection;
    }
}
