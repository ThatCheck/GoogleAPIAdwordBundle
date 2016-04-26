<?php

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('thatcheck_google_api_adword');

        $rootNode
            ->children()
            ->scalarNode('oauth2_client_id')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('oauth2_client_secret')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('redirect_uri')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('oauth2_refresh_token')->end()
            ->scalarNode('user_agent')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('developer_key')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('client_customer_id')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('path_oauth2_credential')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('path_settings_ini')->end()
            ->scalarNode('log_all')->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
