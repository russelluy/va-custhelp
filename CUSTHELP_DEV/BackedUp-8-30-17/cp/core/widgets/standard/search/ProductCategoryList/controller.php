<?php /* Originating Release: May 2016 */


namespace RightNow\Widgets;

class ProductCategoryList extends \RightNow\Libraries\Widget\Base
{
    function __construct($attrs)
    {
        parent::__construct($attrs);
    }

    function getData()
    {
        $this->data['attrs']['data_type'] = strtolower($this->data['attrs']['data_type']);
        $topLevelIDs = $this->data['attrs']['only_display'];
        $this->data['results'] = $this->CI->model('Prodcat')->getHierarchy(
            $this->data['attrs']['data_type'],
            $this->data['attrs']['levels'],
            $this->data['attrs']['maximum_top_levels'],
            $topLevelIDs ? explode(',', $topLevelIDs) : array()
        )->result;

        if($this->data['attrs']['add_params_to_url']) {
            $this->data['appendedParameters'] = \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']);
        }

        if(!count($this->data['results'])) {
            return false;
        }

        $this->data['type'] = ($this->data['attrs']['data_type'] === 'products') ? 'p' : 'c';
    }
}
