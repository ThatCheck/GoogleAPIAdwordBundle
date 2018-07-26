<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 05/06/2015
 * Time: 15:16.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

use Google\AdsApi\AdWords\v201802\cm\CampaignPage;
use Google\AdsApi\AdWords\v201802\cm\CampaignService;

class GoogleAPIAdwordCampaignService extends AbstractServiceManagement
{
    /**
     * @param $client
     */
    public function __construct($client)
    {
        parent::__construct($client);
    }
    /**
     * @return \SoapClient
     */
    public function getCampaignService()
    {
        $this->setCustomerId(null);
        return $this->getService(CampaignService::class);
    }

    /**
     * @param $selector
     *
     * @return CampaignPage
     */
    public function getCampaign($selector)
    {
        $campaignService = $this->getCampaignService();
        return $campaignService->get($selector);
    }

}
