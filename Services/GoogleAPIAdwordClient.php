<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 05/06/2015
 * Time: 09:19.
 */
namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

class GoogleAPIAdwordClient
{
    /**
     * @var \AdWordsUser
     */
    private $adwordUser;

    /**
     * @var bool
     */
    private $validateOnly;

    /**
     * GoogleAPIAdwordClient constructor.
     *
     * @param $client_id
     * @param $client_secret
     * @param $refresh_token
     * @param $developper_token
     * @param $user_agent
     * @param $client_customer_id
     * @param $pathToOauthCredentials
     * @param bool|false $logAll
     */
    public function __construct($client_id, $client_secret, $refresh_token, $developper_token, $user_agent, $client_customer_id, $pathToOauthCredentials, $logAll, $pathSettings)
    {
        $this->validateOnly = false;
        $oauth2Info = array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'refresh_token' => $refresh_token,
        );

        if (is_file($pathToOauthCredentials)) {
            $data = file_get_contents($pathToOauthCredentials);
            $oauth2Info = json_decode($data, true);
        }
        // See AdWordsUser constructor
        $this->adwordUser = new \AdWordsUser(null, $developper_token, $user_agent, $client_customer_id, $pathSettings, $oauth2Info);
        if ($logAll === true) {
            $this->adwordUser->LogAll();
        } else {
            $this->adwordUser->LogErrors();
        }
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
     * @return \AdWordsUser
     */
    public function getAdwordUser()
    {
        return $this->adwordUser;
    }
}
