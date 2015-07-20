<?php
/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 20/07/2015
 * Time: 16:48
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

/**
 * Class GoogleAPIAdwordAdGroupAdService
 * @package Thatcheck\Bundle\GoogleAPIAdwordBundle\Services
 */
class GoogleAPIAdwordAdGroupAdService {

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
    public function getAdGroupAdService()
    {
        return $this->client->getAdwordUser()->GetService('AdGroupAdService');
    }

    /** Get all addgroupId for a specific campaign
     * @param $campaign
     * @return array
     */
    public function getAllAdForAdGroup(array $adGroupId )
    {
        $adGroupAdService = $this->getAdGroupAdService();
        $selector = new \Selector();
        $selector->fields = array('Headline', 'Id', 'Description1', 'Description2', 'DisplayUrl', 'Url', 'Status', 'AverageCpc', 'AveragePosition', 'Clicks', 'Conversions', 'Cost', 'Ctr', 'Impressions');
        $selector->ordering[] = new \OrderBy('Headline', 'ASCENDING');

        // Create predicates.
        $selector->predicates[] = new \Predicate('AdGroupId', 'IN', array($adGroupId));;
        // By default disabled ads aren't returned by the selector. To return them
        // include the DISABLED status in a predicate.
        $selector->predicates[] = new \Predicate('Status', 'NOT_IN', array('DISABLED', 'PAUSED'));

        // Create paging controls.
        $selector->paging = new \Paging(0, \AdWordsConstants::RECOMMENDED_PAGE_SIZE);

        $ret = array();
        do {
            // Make the get request.
            $page = $adGroupAdService->get($selector);

            // Display results.
            if (isset($page->entries)) {
                foreach ($page->entries as $adGroupAd) {
                    $cr = 0;
                    if($adGroupAd->stats->clicks > 0)
                        $cr = $adGroupAd->stats->conversions / $adGroupAd->stats->clicks;

                    $ret[] = array(
                        'headline' => $adGroupAd->ad->headline,
                        'id' => $adGroupAd->ad->id,
                        'textrow1' => $adGroupAd->ad->description1,
                        'textrow2' => $adGroupAd->ad->description2,
                        'view_url' => $adGroupAd->ad->displayUrl,
                        'target_url' => $adGroupAd->ad->url,
                        'active' => (strcmp($adGroupAd->status,'ENABLED')==0)?1:0,
                        'clicks' => $adGroupAd->stats->clicks,
                        'cpc' => $adGroupAd->stats->averageCpc->microAmount / 1000000,
                        'conversions' => $adGroupAd->stats->conversions,
                        'cost' => $adGroupAd->stats->cost->microAmount / 1000000,
                        'ctr' => $adGroupAd->stats->ctr,
                        'impressions' => $adGroupAd->stats->impressions,
                        'cr' => $cr,
                        'position' => $adGroupAd->stats->averagePosition
                    );
                }
            } else {
                //print "No text ads were found.\n";
            }

            // Advance the paging index.
            $selector->paging->startIndex += \AdWordsConstants::RECOMMENDED_PAGE_SIZE;
        } while ($page->totalNumEntries > $selector->paging->startIndex);
        return $ret;
    }
} 