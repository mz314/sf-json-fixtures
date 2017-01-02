<?php

namespace MZ314\JsonFixturesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('json_fixtures');


        $rootNode
            ->children()
                ->scalarNode('fixtures_dir')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('default_output')
                ->defaultValue('stdout')
            ->end();

//            ->children()
//               ->arrayNode('fixture_dir');

        return $treeBuilder;
    }
}