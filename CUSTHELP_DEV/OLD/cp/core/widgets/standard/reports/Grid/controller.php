<?php /* Originating Release: November 2014 */


namespace RightNow\Widgets;

class Grid extends \RightNow\Libraries\Widget\Base
{
    function __construct($attrs)
    {
        parent::__construct($attrs);
    }

    function getData()
    {
        $format = array(
            'truncate_size' => $this->data['attrs']['truncate_size'],
            'max_wordbreak_trunc' => $this->data['attrs']['max_wordbreak_trunc'],
            'emphasisHighlight' => $this->data['attrs']['highlight'],
            'recordKeywordSearch' => true,
            'dateFormat' => $this->data['attrs']['date_format'],
            'urlParms' => \RightNow\Utils\Url::getParametersFromList($this->data['attrs']['add_params_to_url']),
            'hiddenColumns' => true,
        );

        $filters = array('recordKeywordSearch' => true);
        \RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
        $reportToken = \RightNow\Utils\Framework::createToken($this->data['attrs']['report_id']);
        $results = $this->CI->model('Report')->getDataHTML($this->data['attrs']['report_id'], $reportToken, $filters, $format)->result;
        if ($results['error'] !== null)
        {
            echo $this->reportError($results['error']);
            return false;
        }
        $this->data['tableData'] = $results;
        if(count($this->data['tableData']['data']) === 0 && $this->data['attrs']['hide_when_no_results'])
        {
            $this->classList->add('rn_Hidden');
        }
        $filters['page'] = $results['page'];
        $this->data['js'] = array(
            'filters'       => $filters,
            'columnID'      => (int) $filters['sort_args']['filters']['col_id'],
            'sortDirection' => (int) $filters['sort_args']['filters']['sort_direction'],
            'format'        => $format,
            'token'         => $reportToken,
            'headers'       => $this->data['tableData']['headers'],
            'rowNumber'     => $this->data['tableData']['row_num'],
            'searchName'    => 'sort_args',
            'dataTypes'     => array('date' => VDT_DATE, 'datetime' => VDT_DATETIME, 'number' => VDT_INT)
        );
    }
}
