<?php

declare(strict_types=1);

namespace Phauthentic\CorrelationIdBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('correlation_id');

        /* @phpstan-ignore-next-line */
        $treeBuilder->getRootNode()
            ->children()
                ->booleanNode('pass_through')
                    ->defaultValue(false)
                ->end()
                ->scalarNode('response_header_name')
                    ->defaultValue('X-Correlation-ID')
                ->end()
                ->scalarNode('request_header_name')
                    ->defaultValue('X-Correlation-ID')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
