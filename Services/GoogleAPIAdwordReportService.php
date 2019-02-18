<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 08/06/2015
 * Time: 15:16.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

use Google\AdsApi\AdWords\Reporting\v201809\ReportDefinition;
use Google\AdsApi\AdWords\Reporting\v201809\ReportDownloader;
use Thatcheck\Bundle\GoogleAPIAdwordBundle\Request\CustomRequestOptionFactory;

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
     * @return \Google\AdsApi\Common\AdsSoapClient
     */
    public function getReportService()
    {
        return $this->getService('ReportDefinitionService');
    }

    /**
     * Get an adwords reports∂
     * @param $clientId
     * @param ReportDefinition $reportDefinition
     * @param array $options
     * @return string
     */
    public function getReport($clientId, ReportDefinition $reportDefinition, $options = array())
    {
        if(!empty($options)){
            CustomRequestOptionFactory::buildRequestOptionsFactory($this->getClient()->getSessionBuilder(), $options);
        }
        $this->getClient()->buildWithId($clientId);
        $reportDownloader = new ReportDownloader($this->getClient()->getSession());
        return $reportDownloader->downloadReport($reportDefinition)->getAsString();
    }
}
