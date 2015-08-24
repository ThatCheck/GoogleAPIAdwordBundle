<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 20/07/2015
 * Time: 16:43.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

/**
 * Class GoogleAPIAdwordAdGroupService.
 */
class GoogleAPIAdwordAdGroupService extends AbstractServiceManagement
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
    public function getAdGroupService()
    {
        return $this->getService('AdGroupService');
    }

    /** Get all addgroupId for a specific campaign
     * @param $campaign
     *
     * @return array
     */
    public function getAllAdGroupIdForCampaign($campaign)
    {
        $adgroupService = $this->getAdGroupService();
        $selector = new \Selector();
        $selector->fields = array('Id', 'Name', 'CampaignId', 'CampaignName', 'Status', 'Settings', 'Labels','TrackingUrlTemplate');
        $selector->ordering[] = new \OrderBy('CampaignId', 'ASCENDING');

        // Filter out deleted criteria.
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
                    $ret[] = $adgroup;
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
