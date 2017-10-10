<?php
namespace RightNow\Controllers;
require_once CPCORE . "Libraries/ThirdParty/SitemapWriter.php";

use RightNow\Utils\Url;

/**
 * Provides information to search engines for all public answers on the site. ({@link http://en.wikipedia.org/wiki/Site_map})
 */
final class Sitemap extends Base
{
    /**
     * The page of the sitemap being requested.
     */
    private $pageNumber = 0;
    private $xmlGenerator;

    private static $answerReportID = 10014;

    public function __construct()
    {
        parent::__construct();

        if (!\RightNow\Utils\Config::getConfig(KB_SITEMAP_ENABLE))
            exit;

        $this->xmlGenerator = new \RightNow\Libraries\ThirdParty\GsgXml("");
    }

    /**
     * Returns the sitemap XML for all public answers
     */
    public function index()
    {
        $this->_process();
    }

    /**
     * Allows for paging of sitemap results
     */
    public function page()
    {
        $this->pageNumber = (int) $this->uri->segment(3, 0);
        $this->_process();
    }

    /**
     * Returns the sitemap for all public answers but in HTML
     */
    public function html()
    {
        $this->_process(true);
    }

    /**
     * Calculate the contents of the sitemap.
     * @param boolean $htmlMode Whether the results should be output
     *                          as HTML or XML (default)
     */
    private function _process($htmlMode = false)
    {
        $reportSettings = ($htmlMode) ? $this->_getReportSettings() : $this->_getReportSettingsForXmlOutput();
        $results = @$this->model('Report')->getDataHTML(self::$answerReportID,
            \RightNow\Utils\Framework::createToken(self::$answerReportID), $reportSettings['filters'], $reportSettings['format'])->result;

        if (!isset($results['data']) || count($results['data']) === 0) exit;

        if ($htmlMode)
        {
            $this->_outputHtmlResults($results);
            exit;
        }

        $this->_outputXmlResults($results);
    }

    /**
     * Calculates priority of how often page should be spidered
     *
     * @param int $score Link score
     * @param int $totalPages Total number of pages
     * @param int $maxScore Max score
     * @return int Normalized priority
     */
    private function _calculatePriority($score, $totalPages, $maxScore)
    {
        $normalScore = $score / $maxScore;
        $lowScore = ($totalPages - $this->pageNumber) / $totalPages;
        return ($normalScore / $totalPages) + $lowScore;
    }

    /**
     * Processes answer urls
     *
     * @param string $link String which contains a href to an answer page
     * @param string $summary String which contains summary of the answer
     * @return array Array of [ /app/path/to/answer/a_id/id/~/answer-summary-slug, id ]
     */
    private function _processAnswerLink($link, $summary) {
        if(!$summary || !preg_match('@href=["|\'](.*)["|\'][^>]*>(.*)<\/a>@', $link, $matches)) {
            return array();
        }

        return array(
            $matches[1] . "/~/" . \RightNow\Libraries\SEO::getAnswerSummarySlug($summary),
            $matches[2]
        );
    }

    /**
     * Default report format and filters.
     * @return array Contains filters and format keys
     */
    private function _getReportSettings()
    {
        $format = array(
            'raw_date'   => true,
            'no_session' => true,
        );
        $filters = array(
            'sitemap'     => true,
            'no_truncate' => 1,
            'per_page'    => PHP_INT_MAX,
        );

        if ($this->pageNumber !== 0)
            $filters['page'] = $this->pageNumber;

        return array('filters' => $filters, 'format' => $format);
    }

    /**
     * Default report format and filters for the particulars of
     * the xml generator library.
     * @return array Contains filters and format keys
     */
    private function _getReportSettingsForXmlOutput()
    {
        $settings = $this->_getReportSettings();
        $settings['filters']['per_page'] = $this->xmlGenerator->maxURLs;
        return $settings;
    }

    /**
     * Outputs XML results suitable for spider consumption.
     * @param array $results Results from report model
     */
    private function _outputXmlResults(array $results)
    {
        $totalPages = $results['total_pages'];

        if (($this->pageNumber === 0) && ($totalPages > 1))
        {
            // if the page was called with no page number and we have more
            // than one page, then create a sitemap index
            for ($i = 1; $i <= $totalPages; $i++)
            {
                $this->xmlGenerator->addSitemapUrl(Url::getShortEufBaseUrl('sameAsCurrentPage', "/ci/sitemap/page/$i"));
            }
        }
        else
        {
            if ($this->pageNumber === 0)
                $this->pageNumber = 1;

            $maxScore = 0;

            foreach ($results['data'] as $row)
            {
                list($answerUrl, $score, $lastModified, $title) = $row;
                list($path) = $this->_processAnswerLink($answerUrl, $title);
                $url = Url::getShortEufBaseUrl('sameAsCurrentPage', $path);

                if (!$maxScore)
                {
                    // The report is sorted by score, so the
                    // first result has the max score.
                    $maxScore = $score > 0 ? $score : 100000;
                }
                $priority = $this->_calculatePriority($score, $totalPages, $maxScore);

                $this->xmlGenerator->addUrl($url,
                    false, //path only,
                    $lastModified,
                    false, //Include time in timestamp
                    null, //change frequency
                    $priority);
            }
        }
        $this->xmlGenerator->output(false, false, true);
    }

    /**
     * Outputs HTML answer links.
     * @param array $results Results from report model
     */
    private function _outputHtmlResults(array $results)
    {
        $links = array();
        foreach ($results['data'] as $row)
        {
            list($path, $id) = $this->_processAnswerLink($row[0], $row[3]);
            $url = Url::getShortEufBaseUrl('sameAsCurrentPage', $path);
            $links []= "<a href='$url'>{$id}</a>";
        }
        $links = implode("<br>\n", $links);

        echo <<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>HTML Sitemap</title>
        <meta name="ROBOTS" content="NOINDEX">
    </head>
    <body>
    {$links}
    </body>
</html>
HTML;
    }
}
