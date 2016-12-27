<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 19/08/2015
 * Time: 11:13.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;
use Google\AdsApi\AdWords\AdWordsServices;
use Google\AdsApi\Common\AdsSoapClient;

/**
 * Class AbstarctServiceManagement.
 */
abstract class AbstractServiceManagement
{
    /**
     * @var GoogleAPIAdwordClient
     */
    protected $client;

    /**
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param string $className
     *
     * @return AdsSoapClient
     */
    public function getService($className)
    {
        $adwordsServices = new AdWordsServices();

        return $adwordsServices->get($this->client->getSession(), $className);
    }

    /**
     * Get client
     */
    public function getClient()
    {
        return $this->client;
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
        $this->client->buildWithId($id);
        return $this;
    }
}
