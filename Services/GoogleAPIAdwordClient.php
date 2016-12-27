<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 05/06/2015
 * Time: 09:19.
 */
namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

use Google\AdsApi\AdWords\AdWordsSession;
use Google\AdsApi\AdWords\AdWordsSessionBuilder;
use Google\AdsApi\Common\OAuth2TokenBuilder;
use Psr\Log\LoggerInterface;

class GoogleAPIAdwordClient
{

    /**
     * @var AdWordsSession
     */
    private $session;

    /**
     * @var AdWordsSessionBuilder
     */
    private $sessionBuilder;

    /**
     * @var string
     */
    private $configFile;

    /**
     * @var string
     */
    private $oauthCredentials;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * GoogleAPIAdwordClient constructor.
     * @param $configFile
     * @param LoggerInterface $logger
     */
    public function __construct($configFile, LoggerInterface $logger)
    {
        $this->configFile = $configFile;
        $this->logger = $logger;
        $this->oauthCredentials = (new OAuth2TokenBuilder())->fromFile($configFile)->build();
        $this->buildSession();
    }

    /**
     * @param null $id
     * @return $this
     */
    public function buildWithId($id = null)
    {
        if($id !== null){
            $this->sessionBuilder = $this->sessionBuilder->withClientCustomerId($id);
        }

        $this->session = $this->sessionBuilder->build();
        return $this;
    }

    /**
     * @return AdWordsSession
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return AdWordsSessionBuilder
     */
    public function getSessionBuilder()
    {
        return $this->sessionBuilder;
    }

    /**
     * @return AdWordsSessionBuilder
     */
    private function buildSession()
    {
        $this->sessionBuilder = (new AdWordsSessionBuilder())
            ->fromFile($this->configFile)
            ->withOAuth2Credential($this->oauthCredentials);

        $this->sessionBuilder->withSoapLogger($this->logger);
        $this->sessionBuilder->withReportDownloaderLogger($this->logger);
        $this->sessionBuilder->withBatchJobsUtilLogger($this->logger);
    }


}
