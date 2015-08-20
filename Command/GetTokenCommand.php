<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 05/06/2015
 * Time: 09:13.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Command;

class GetTokenCommand extends \Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('thatcheck:google_adword_api:generate_token')
            ->setDescription('get a token for adword api google')
        ;
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $oauth2Info = array(
            'client_id' => $this->getContainer()->getParameter('thatcheck_google_api_adword.oauth2_client_id'),
            'client_secret' => $this->getContainer()->getParameter('thatcheck_google_api_adword.oauth2_client_secret'),
        );
        $user = new \AdWordsUser(null, null, null, null, null, $oauth2Info);
        $user->LogAll();
        $redirectUri =  $this->getContainer()->getParameter('thatcheck_google_api_adword.redirect_uri');
        $offline = true;

        $OAuth2Handler = $user->GetOAuth2Handler();
        $authorizationUrl = $OAuth2Handler->GetAuthorizationUrl($user->GetOAuth2Info(), $redirectUri, $offline, array('approval_prompt' => 'force'));
        $output->writeln('Log in to your AdWords account and open the following URL: '.$authorizationUrl);

        $dialog = $this->getHelperSet()->get('dialog');
        $code = $dialog->ask(
            $output,
            'Access Token :'
        );

        $refreshToken = $OAuth2Handler->GetAccessToken($user->GetOAuth2Info(), trim($code), $redirectUri);

        $user->SetOAuth2Info($refreshToken);

        $fs = new \Symfony\Component\Filesystem\Filesystem();
        $fs->dumpFile($this->getContainer()->getParameter('thatcheck_google_api_adword.path_oauth2_credential'), json_encode($user->GetOAuth2Info()));
        $output->writeln('Refresh Token => '.$refreshToken['access_token']);
    }
}
