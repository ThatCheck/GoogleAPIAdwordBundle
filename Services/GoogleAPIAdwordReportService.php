<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 08/06/2015
 * Time: 15:16.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

class GoogleAPIAdwordReportService
{
    /**
     * @var GoogleAPIAdwordClient
     */
    private $client;

    /**
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    public function getReportService()
    {
        return $this->client->getAdwordUser()->GetService('ReportDefinitionService');
    }

    public function getReport($clientId, \ReportDefinition $reportDefinition, array $options)
    {
        $this->client->getAdwordUser()->SetClientCustomerId($clientId);

        return \ReportUtils::DownloadReport($reportDefinition, null, $this->client->getAdwordUser(), $options);
    }
}
