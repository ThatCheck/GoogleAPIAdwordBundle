<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 05/06/2015
 * Time: 16:12.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

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

    public function getManagedCustomerService()
    {
        return $this->getService('ManagedCustomerService');
    }

    public function getAccountHierarchy($selector)
    {
        $managedCustomerService = $this->getManagedCustomerService();

        $graph = $managedCustomerService->get($selector);

        return $graph;
    }
}
