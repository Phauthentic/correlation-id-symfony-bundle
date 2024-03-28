<?php

declare(strict_types=1);

namespace Phauthentic\CorrelationIdBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class CorrelationIdExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('correlation_id.request_header_name', $config['response_header_name']);
        $container->setParameter('correlation_id.response_header_name', $config['response_header_name']);
        $container->setParameter('correlation_id.pass_through', $config['pass_through']);

        $yamlLoader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../config')
        );

        $yamlLoader->load('services.yaml');
    }
}
