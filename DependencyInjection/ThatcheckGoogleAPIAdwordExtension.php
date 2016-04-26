<?php

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ThatcheckGoogleAPIAdwordExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('thatcheck_google_api_adword', $config);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('thatcheck_google_api_adword.oauth2_client_id', $config['oauth2_client_id']);
        $container->setParameter('thatcheck_google_api_adword.oauth2_client_secret', $config['oauth2_client_secret']);
        if (array_key_exists('oauth2_refresh_token', $config)) {
            $container->setParameter('thatcheck_google_api_adword.oauth2_refresh_token', $config['oauth2_refresh_token']);
        } else {
            $container->setParameter('thatcheck_google_api_adword.oauth2_refresh_token', '');
        }
        $container->setParameter('thatcheck_google_api_adword.user_agent', $config['user_agent']);
        $container->setParameter('thatcheck_google_api_adword.developer_key', $config['developer_key']);
        $container->setParameter('thatcheck_google_api_adword.redirect_uri', $config['redirect_uri']);
        $container->setParameter('thatcheck_google_api_adword.client_customer_id', $config['client_customer_id']);
        if (array_key_exists('log_all', $config)) {
            $container->setParameter('thatcheck_google_api_adword.log_all', $config['log_all']);
        } else {
            $container->setParameter('thatcheck_google_api_adword.log_all', false);
        }

        if (array_key_exists('path_oauth2_credential', $config)) {
            $container->setParameter('thatcheck_google_api_adword.path_oauth2_credential', $config['path_oauth2_credential']);
        } else {
            $container->setParameter('thatcheck_google_api_adword.path_oauth2_credential', __DIR__.'/oaut2_credentials/credentials.json');
        }

        if (array_key_exists('path_settings_ini', $config)) {
            $container->setParameter('thatcheck_google_api_adword.path_settings_ini', $config['path_settings_ini']);
        } else {
            $container->setParameter('thatcheck_google_api_adword.path_settings_ini', null);
        }

        $fs = new \Symfony\Component\Filesystem\Filesystem();
        $folder = $container->getParameter('thatcheck_google_api_adword.path_oauth2_credential');
        if (is_dir($folder)) {
            $fs->mkdir($folder);
        }
    }
}
