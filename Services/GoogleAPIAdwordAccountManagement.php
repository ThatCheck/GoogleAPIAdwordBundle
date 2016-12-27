<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 05/06/2015
 * Time: 16:12.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;
use Google\AdsApi\AdWords\v201609\mcm\ManagedCustomerPage;
use Google\AdsApi\AdWords\v201609\mcm\ManagedCustomerService;
use Google\AdsApi\Common\AdsSoapClient;

/**
 * Class GoogleAPIAdwordAccountManagement.
 */
class GoogleAPIAdwordAccountManagement extends AbstractServiceManagement
{
    /**
     * @param $client
     */
    public function __construct($client)
    {
        parent::__construct($client);
    }

    /**
     * @return AdsSoapClient
     */
    public function getManagedCustomerService()
    {
        return $this->getService(ManagedCustomerService::class);
    }

    /**
     * @param $selector
     * @return ManagedCustomerPage
     */
    public function getAccountHierarchy($selector)
    {
        $managedCustomerService = $this->getManagedCustomerService();

        $graph = $managedCustomerService->get($selector);

        return $graph;
    }
}
