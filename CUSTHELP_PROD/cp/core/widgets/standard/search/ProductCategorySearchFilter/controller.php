<?php /* Originating Release: November 2014 */


namespace RightNow\Widgets;

use RightNow\Utils\Text;

class ProductCategorySearchFilter extends \RightNow\Libraries\Widget\Base
{
    const PRODUCT = 'Product';
    const CATEGORY = 'Category';

    function __construct($attrs)
    {
        parent::__construct($attrs);
    }

    function getData()
    {
        $this->data['attrs']['filter_type'] = (Text::stringContains(strtolower($this->data['attrs']['filter_type']), 'prod'))
            ? self::PRODUCT
            : self::CATEGORY;

        // all of the label defaults are for products - if the filter type is category, see if
        // the labels have the product default value and replace them with the category default value
        // otherwise, the attribute values were modified and should persist
        if ($this->data['attrs']['filter_type'] === self::CATEGORY)
        {
            $this->data['attrs']['label_all_values'] =
                ($this->data['attrs']['label_all_values'] === \RightNow\Utils\Config::getMessage(ALL_PRODUCTS_LBL))
                ? \RightNow\Utils\Config::getMessage(ALL_CATEGORIES_LBL)
                : $this->data['attrs']['label_all_values'];

            $this->data['attrs']['label_input'] =
                ($this->data['attrs']['label_input'] === \RightNow\Utils\Config::getMessage(LIMIT_BY_PRODUCT_LBL))
                ? \RightNow\Utils\Config::getMessage(LIMIT_BY_CATEGORY_LBL)
                : $this->data['attrs']['label_input'];

            $this->data['attrs']['label_nothing_selected'] =
                ($this->data['attrs']['label_nothing_selected'] === \RightNow\Utils\Config::getMessage(SELECT_A_PRODUCT_LBL))
                ? \RightNow\Utils\Config::getMessage(SELECT_A_CATEGORY_LBL)
                : $this->data['attrs']['label_nothing_selected'];
        }

        //Get the active filters on the page to determine the default value
        $filters = array();
        \RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
        $filterType = strtolower($this->data['attrs']['filter_type'][0]);
        if(!$filters[$filterType]->filters->optlist_id) {
            echo $this->reportError(sprintf(\RightNow\Utils\Config::getMessage(FILTER_PCT_S_EXIST_REPORT_PCT_D_LBL), $this->data['attrs']['filter_type'], $this->data['attrs']['report_id']));
            return false;
        }

        $trimmedTreeViewCss = trim($this->data['attrs']['treeview_css']);
        if ($trimmedTreeViewCss !== '')
            $this->addStylesheet($trimmedTreeViewCss);

        $this->data['js'] = array(
            'oper_id'     => $filters[$filterType]->filters->oper_id,
            'fltr_id'     => $filters[$filterType]->filters->fltr_id,
            'linkingOn'   => $this->data['attrs']['linking_off'] ? 0 : $this->CI->model('Prodcat')->getLinkingMode(),
            'report_def'  => $filters[$filterType]->report_default,
            'searchName'  => $filterType,
            'hm_type' => ($filterType === 'p') ? HM_PRODUCTS : HM_CATEGORIES,
        );

        //Find the default chain in the search filters and generate the appropriate data tree for viewing the widget
        //with that selection.
        $dataType = $this->data['attrs']['filter_type'];
        $defaultChain = $filters[$filterType]->filters->data[0];
        $defaultChain = $this->data['js']['initial'] = ($defaultChain) ? explode(',', $defaultChain) : array();
        if($this->data['js']['linkingOn'] && $dataType === self::CATEGORY) {
            $defaultProductID = end(explode(',', $filters['p']->filters->data[0])) ?: null;
            $this->data['js']['link_map'] = $defaultHierMap = $this->CI->model('Prodcat')->getFormattedTree($dataType, $defaultChain, true, $defaultProductID)->result;
            $this->data['js']['hierDataNone'] = $this->CI->model('Prodcat')->getFormattedTree($dataType, array(), true)->result;
            array_unshift($this->data['js']['hierDataNone'][0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
            array_unshift($this->data['js']['link_map'][0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
        }
        else {
            $defaultHierMap = $this->CI->model('Prodcat')->getFormattedTree($dataType, $defaultChain)->result;
        }

        //Add in our all values labels
        array_unshift($defaultHierMap[0], array('id' => 0, 'label' => $this->data['attrs']['label_all_values']));
        $this->data['js']['hierData'] = $defaultHierMap;
    }
}
