<?php
/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 20/07/2015
 * Time: 16:43
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;


/**
 * Class GoogleAPIAdwordAdGroupService
 * @package Thatcheck\Bundle\GoogleAPIAdwordBundle\Services
 */
class GoogleAPIAdwordAdGroupService {

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
    public function getAdGroupService()
    {
        return $this->client->getAdwordUser()->GetService('AdGroupService');
    }

    /** Get all addgroupId for a specific campaign
     * @param $campaign
     * @return array
     */
    public function getAllAdGroupIdForCampaign($campaign)
    {
        $adgroupService = $this->getAdGroupService();
        $selector = new \Selector();
        $selector->fields = array('Id', 'Name', 'CampaignId', 'Status');
        $selector->ordering[] = new \OrderBy('CampaignId', 'ASCENDING');

        // Filter out deleted criteria.
        $selector->predicates[] = new \Predicate('Status', 'NOT_IN', array('DELETED', 'PAUSED'));
        $selector->predicates[] = new \Predicate('CampaignId', 'IN', array($campaign));
        // Create paging controls.
        $selector->paging = new \Paging(0, \AdWordsConstants::RECOMMENDED_PAGE_SIZE);

        $ret = array();
        do {
            // Make the get request.
            $page = $adgroupService->get($selector);

            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $adgroup) {
                    //printf("AdGroup with name '%s' and id '%s' was found for Campaign: '%s' and Status: '%s'\n",
                    // $adgroup->name, $adgroup->id, $adgroup->campaignId, $adgroup->status);
                    $ret[] = array(
                        'name' => $adgroup->name,
                        'id' => $adgroup->id,
                        'campaignId' => $adgroup->campaignId,
                        'active' => (strcmp($adgroup->status,'ENABLED')==0)?1:0
                    );
                }
            } else {
                //print "No adgroups were found.\n";
            }
            // Advance the paging index.
            $selector->paging->startIndex += \AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);

        return $ret;
    }
} 