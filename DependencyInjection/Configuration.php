<?php

namespace Clab\PayzenBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
    	$treeBuilder = new TreeBuilder();
    	$rootNode = $treeBuilder->root('clab_payzen');

    	$rootNode
    	    ->addDefaultsIfNotSet()
    	    ->children()

    		->arrayNode('parameters')
    		    ->isRequired()
    		    ->children()
    			->scalarNode('site')->isRequired()->end()
    			->scalarNode('certificate')->isRequired()->end()
                ->scalarNode('testcertificate')->isRequired()->end()
    		    ->end()
    		->end()

            ->arrayNode('parameters2')
                ->isRequired()
                ->children()
                ->scalarNode('site')->isRequired()->end()
                ->scalarNode('certificate')->isRequired()->end()
                ->scalarNode('testcertificate')->isRequired()->end()
                ->end()
            ->end()

    	    ->end()
    	;

    	return $treeBuilder;
    }
}
