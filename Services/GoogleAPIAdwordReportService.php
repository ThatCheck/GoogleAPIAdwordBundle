<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 08/06/2015
 * Time: 15:16.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;
use Google\AdsApi\AdWords\ReportSettingsBuilder;
use Google\AdsApi\AdWords\v201601\cm\Selector;
use Google\AdsApi\Dfp\Util\v201511\ReportDownloader;

/**
 * Class GoogleAPIAdwordReportService
 * @package Thatcheck\Bundle\GoogleAPIAdwordBundle\Services
 */
class GoogleAPIAdwordReportService extends AbstractServiceManagement
{
    /**
     * @param $client
     */
    public function __construct($client)
    {
        parent::__construct($client);
    }

    /**
     * @param $clientId
     * @param Selector $selector
     * @return mixed
     */
    public function getReport($clientId, Selector $selector)
    {
        $session = $this->client->getAdWordsSessionBuilder()->withClientCustomerId($clientId)->build();
        $reportDownloaderService = $this->client->getAdWordsServices()->get($session, 'ReportDefinitionService', 'v201601', 'cm');
        return $reportDownloaderService->get($selector);
    }
}
