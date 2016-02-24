<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 05/06/2015
 * Time: 09:19.
 */
namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

use Google\AdsApi\AdWords\AdWordsServices;
use Google\AdsApi\AdWords\AdWordsSessionBuilder;
use Google\AdsApi\AdWords\ReportSettingsBuilder;
use Google\AdsApi\Common\Util\SimpleGoogleCredential;

/**
 * Class GoogleAPIAdwordClient
 * @package Thatcheck\Bundle\GoogleAPIAdwordBundle\Services
 */
class GoogleAPIAdwordClient
{
    /**
     * @var SimpleGoogleCredential
     */
    private $simpleGoogleCredential;
    /**
     * @var AdWordsSessionBuilder
     */
    private $adWordsSessionBuilder;
    /**
     * @var AdWordsServices
     */
    private $adWordsServices;

    /**
     * @var bool
     */
    private $validateOnly;

    /**
     * GoogleAPIAdwordClient constructor.
     * @param $pathToOauthCredentials
     * @param bool|false $logAll
     */
    public function __construct($pathToOauthCredentials, $logAll = false)
    {
        $this->validateOnly = false;
        $this->simpleGoogleCredential = new SimpleGoogleCredential();
        $this->simpleGoogleCredential->fromFile($pathToOauthCredentials);

        $this->adWordsSessionBuilder = new AdWordsSessionBuilder();
        $this->adWordsSessionBuilder = $this->adWordsSessionBuilder->fromFile($pathToOauthCredentials)
            ->withOAuth2Credential($this->simpleGoogleCredential)
            ->build();

        $this->adWordsServices = new AdWordsServices();
    }

    /**
     * @return bool
     */
    public function isValidateOnly()
    {
        return $this->validateOnly;
    }

    /**
     * @param bool $validateOnly
     */
    public function setValidateOnly($validateOnly)
    {
        $this->validateOnly = $validateOnly;
    }

    /**
     * @return SimpleGoogleCredential
     */
    public function getSimpleGoogleCredential()
    {
        return $this->simpleGoogleCredential;
    }

    /**
     * @param SimpleGoogleCredential $simpleGoogleCredential
     */
    public function setSimpleGoogleCredential($simpleGoogleCredential)
    {
        $this->simpleGoogleCredential = $simpleGoogleCredential;
    }

    /**
     * @return AdWordsSessionBuilder
     */
    public function getAdWordsSessionBuilder()
    {
        return $this->adWordsSessionBuilder;
    }

    /**
     * @param AdWordsSessionBuilder $adWordsSessionBuilder
     */
    public function setAdWordsSessionBuilder($adWordsSessionBuilder)
    {
        $this->adWordsSessionBuilder = $adWordsSessionBuilder;
    }

    /**
     * @return AdWordsServices
     */
    public function getAdWordsServices()
    {
        return $this->adWordsServices;
    }

    /**
     * @param AdWordsServices $adWordsServices
     */
    public function setAdWordsServices($adWordsServices)
    {
        $this->adWordsServices = $adWordsServices;
    }

    /**
     * @return \Google\AdsApi\AdWords\ReportSettings|mixed
     */
    public function getReportSettingsBuilder()
    {
        return $this->reportSettingsBuilder;
    }

    /**
     * @param \Google\AdsApi\AdWords\ReportSettings|mixed $reportSettingsBuilder
     */
    public function setReportSettingsBuilder($reportSettingsBuilder)
    {
        $this->reportSettingsBuilder = $reportSettingsBuilder;
    }



}
