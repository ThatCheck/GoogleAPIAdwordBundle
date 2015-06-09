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

    public function __construct($client_id, $client_secret, $refresh_token, $developper_token, $user_agent, $client_customer_id, $pathToOauthCredentials)
    {
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
        $this->adwordUser = new \AdWordsUser(null, $developper_token, $user_agent, $client_customer_id, null, $oauth2Info);
        $this->adwordUser->LogAll();
    }

    /**
     * @return \AdWordsUser
     */
    public function getAdwordUser()
    {
        return $this->adwordUser;
    }
}
