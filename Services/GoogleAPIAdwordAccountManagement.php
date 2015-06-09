<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 05/06/2015
 * Time: 16:12.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

class GoogleAPIAdwordAccountManagement
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

    public function getManagedCustomerService()
    {
        return $this->client->getAdwordUser()->GetService('ManagedCustomerService');
    }

    public function getAccountHierarchy($selector)
    {
        $managedCustomerService = $this->getManagedCustomerService();

        $graph = $managedCustomerService->get($selector);

        return $graph;
    }
}
