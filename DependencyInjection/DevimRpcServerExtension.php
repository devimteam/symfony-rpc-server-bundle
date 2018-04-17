<?php

namespace Devim\RpcServerBundle\DependencyInjection;

use Devim\RpcServerBundle\JsonRpcDiscovery;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class DevimRpcServerExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
//        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__).'/../../../config/packages'));
//        $loader->load('devim_rpc_server.yaml');

        (new YamlFileLoader(
            $container,
            new FileLocator(dirname(__DIR__) . '/Resources/config')
        ))->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

//        var_dump($config['classes']);die;

        $definition = $container->getDefinition(JsonRpcDiscovery::class);
        $definition->replaceArgument(1, $config['classes']);
    }
}