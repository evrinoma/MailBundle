<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\MailBundle\DependencyInjection;

use Evrinoma\MailBundle\EvrinomaMailBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(EvrinomaMailBundle::BUNDLE);
        $rootNode = $treeBuilder->getRootNode();
        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->defaultValue('orm')
            ->end()
            ->scalarNode('factory')->cannotBeEmpty()->defaultValue(EvrinomaMailExtension::ENTITY_FACTORY_MAIL)->end()
            ->scalarNode('entity')->cannotBeEmpty()->defaultValue(EvrinomaMailExtension::ENTITY_BASE_MAIL)->end()
            ->scalarNode('constraints')->defaultTrue()->info('This option is used to enable/disable basic mail constraints')->end()
            ->scalarNode('dto')->cannotBeEmpty()->defaultValue(EvrinomaMailExtension::DTO_BASE_MAIL)->info('This option is used to dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command')->defaultNull()->info('This option is used to command mail decoration')->end()
            ->scalarNode('query')->defaultNull()->info('This option is used to query mail decoration')->end()
            ->end()->end()
            ->arrayNode('serializer')->addDefaultsIfNotSet()->children()
            ->scalarNode('enabled')->defaultTrue()->info('This option is used to enable/disable basic video_content serializers')->end()
            ->scalarNode('path')->cannotBeEmpty()->defaultValue(getcwd())->end()
            ->end()->end()
            ->arrayNode('services')->addDefaultsIfNotSet()->children()
            ->scalarNode('pre_validator')->defaultNull()->info('This option is used to pre_validator overriding')->end()
            ->scalarNode('handler')->cannotBeEmpty()->defaultValue(EvrinomaMailExtension::HANDLER)->info('This option is used to handler override')->end()
            ->end()->end()
            ->end();

        return $treeBuilder;
    }
}
