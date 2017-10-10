<?php /* Originating Release: November 2014 */


namespace RightNow\Widgets;

class Paginator extends \RightNow\Libraries\Widget\Base
{
    function __construct($attrs)
    {
        parent::__construct($attrs);
    }

    function getData()
    {
        \RightNow\Utils\Url::setFiltersFromAttributesAndUrl($this->data['attrs'], $filters);
        $reportToken = \RightNow\Utils\Framework::createToken($this->data['attrs']['report_id']);
        $results = $this->CI->model('Report')->getDataHTML($this->data['attrs']['report_id'], $reportToken, $filters, null)->result;

        if(!$this->data['attrs']['maximum_page_links'])
        {
            $this->data['js']['startPage'] = $this->data['js']['endPage'] = $results['page'];
        }
        else if($results['total_pages'] > $this->data['attrs']['maximum_page_links'])
        {
            //calculate how far the page links should be shifted based on the specified cutoff
            $split = round($this->data['attrs']['maximum_page_links'] / 2);
            if($results['page'] <= $split)
            {
                //selected page is halfway (or less) to max_pages, so just stop displaying
                //links at the specified cutoff
                $this->data['js']['startPage'] = 1;
                $this->data['js']['endPage'] = $this->data['attrs']['maximum_page_links'];
            }
            else
            {
                //selected page is is more than half of max_pages, so shift the window of page links
                //by difference between the current page and halfway point
                $offsetFromMiddle = $results['page'] - $split;
                $maxOffset = $offsetFromMiddle + $this->data['attrs']['maximum_page_links'];
                if($maxOffset <= $results['total_pages'])
                {
                    //the shifted window hasn't hit up against the maximum number of pages of the data set
                    $this->data['js']['startPage'] = 1 + $offsetFromMiddle;
                    $this->data['js']['endPage'] = $maxOffset;
                }
                else
                {
                    //the shifted window hit up against the maximum number of pages of the data set,
                    //so stop at the maximum number of pages
                    $this->data['js']['startPage'] = $results['total_pages'] - ($this->data['attrs']['maximum_page_links'] - 1);
                    $this->data['js']['endPage'] = $results['total_pages'];
                }
            }
        }
        else
        {
            $this->data['js']['startPage'] = 1;
            $this->data['js']['endPage'] = $results['total_pages'];
        }

        $this->data['totalPages'] = $results['total_pages'];

        $url = $this->CI->page;
        $this->data['js']['pageUrl'] = "/app/$url/page/";
        $this->data['js']['currentPage'] = $results['page'];
        $this->data['js']['backPageUrl'] = $this->data['js']['pageUrl'] . (intval($this->data['js']['currentPage']) - 1);
        $this->data['js']['forwardPageUrl'] = $this->data['js']['pageUrl'] . (intval($this->data['js']['currentPage']) + 1);

        if ($results['truncated'] || ($results['total_pages'] < 2)) {
            $this->classList->add('rn_Hidden');
        }
        $forwardClass = ($this->data['attrs']['forward_img_path']) ? 'rn_ForwardImageLink' : '';
        $this->data['forwardClass'] = ($results['total_pages'] <= $this->data['js']['currentPage']) ? 'rn_Hidden' : $forwardClass;
        $backClass = ($this->data['attrs']['back_img_path']) ? 'rn_BackImageLink' : '';
        $this->data['backClass'] = ($this->data['js']['currentPage'] <= 1) ? 'rn_Hidden' : $backClass;
    }
}
