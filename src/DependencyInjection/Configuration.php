<?php

declare(strict_types=1);

namespace CORS\Bundle\FriendlyCaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('cors_friendly_captcha');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('secret')->cannotBeEmpty()->isRequired()->end()
                ->scalarNode('sitekey')->cannotBeEmpty()->isRequired()->end()
                ->booleanNode('use_eu_endpoints')->defaultTrue()->end()
                ->arrayNode('puzzle')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('endpoint')->defaultValue('https://api.friendlycaptcha.com/api/v1/puzzle')->end()
                        ->scalarNode('eu_endpoint')->defaultValue('https://eu-api.friendlycaptcha.eu/api/v1/puzzle')->end()
                    ->end()
                ->end()
                ->arrayNode('validation')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('endpoint')->defaultValue('https://api.friendlycaptcha.com/api/v1/siteverify')->end()
                        ->scalarNode('eu_endpoint')->defaultValue('https://eu-api.friendlycaptcha.eu/api/v1/siteverify')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
