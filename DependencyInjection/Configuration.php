<?php

namespace Devim\RpcServerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('devim_rpc_server');

        $rootNode
            ->children()
            ->arrayNode('classes')->prototype('scalar')
            ->end() // classes
            ->end()
        ;

        return $treeBuilder;
    }
}