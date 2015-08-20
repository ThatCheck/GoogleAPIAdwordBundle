<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 19/08/2015
 * Time: 11:13.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

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
     * @param $name
     *
     * @return \SoapClient
     */
    public function getService($name)
    {
        return $this->client->getAdwordUser()->GetService($name, null, null, null, $this->client->isValidateOnly(), null);
    }

    /**
     * @param $validate
     */
    public function getClient()
    {
        return $this->client;
    }
}
