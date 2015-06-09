<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 08/06/2015
 * Time: 10:11.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Command;

use Thatcheck\Bundle\GoogleAPIAdwordBundle\Services\GoogleAPIAdwordClient;

class RefreshAccessTokenCommand extends \Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('thatcheck:google_adword_api:refresh_token')
            ->setDescription('refresh access token for adword api google')
        ;
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        /*
         * @var GoogleAPIAdwordClient
         */
        $client = $this->getContainer()->get('thatcheck_google_api_adword.client');
        $client->getAdwordUser()->GetOAuth2Handler()->RefreshAccessToken($client->getAdwordUser()->GetOAuth2Info());
    }
}
