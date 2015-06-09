<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 05/06/2015
 * Time: 15:16.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

class GoogleAPIAdwordCampaignService
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

    /**
     * @return \SoapClient
     */
    public function getCampaignService()
    {
        return $this->client->getAdwordUser()->GetService('CampaignService');
    }

    /**
     * @param $selector
     *
     * @return array
     */
    public function getCampaign($selector)
    {
        $campaignService = $this->getCampaignService();

        $campaignArray = array();

        // Create paging controls.
        $selector->paging = new \Paging(0, \AdWordsConstants::RECOMMENDED_PAGE_SIZE);
        do {
            // Make the get request.
            $page = $campaignService->get($selector);
            if (isset($page->entries)) {
                foreach ($page->entries as $campaign) {
                    $campaignArray[] = $campaign;
                }
            }
            // Advance the paging index.
            $selector->paging->startIndex += \AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);

        return $campaignArray;
    }

    /**
     * Set the customer-id.
     *
     * @param $id
     *
     * @return $this
     */
    public function setCustomerId($id)
    {
        $this->client->getAdwordUser()->SetClientCustomerId($id);

        return $this;
    }
}
