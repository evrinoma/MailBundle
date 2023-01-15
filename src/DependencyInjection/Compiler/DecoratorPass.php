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

namespace Evrinoma\MailBundle\DependencyInjection\Compiler;

use Evrinoma\MailBundle\EvrinomaMailBundle;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DecoratorPass extends AbstractRecursivePass
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $decoratorQuery = $container->hasParameter('evrinoma.'.EvrinomaMailBundle::BUNDLE.'.decorates.query');
        if ($decoratorQuery) {
            $decoratorQuery = $container->getParameter('evrinoma.'.EvrinomaMailBundle::BUNDLE.'.decorates.query');
            $queryMediator = $container->getDefinition($decoratorQuery);
            $repository = $container->getDefinition('evrinoma.'.EvrinomaMailBundle::BUNDLE.'.repository');
            $repository->setArgument(2, $queryMediator);
        }
        $decoratorCommand = $container->hasParameter('evrinoma.'.EvrinomaMailBundle::BUNDLE.'.decorates.command');
        if ($decoratorCommand) {
            $decoratorCommand = $container->getParameter('evrinoma.'.EvrinomaMailBundle::BUNDLE.'.decorates.command');
            $commandMediator = $container->getDefinition($decoratorCommand);
            $commandManager = $container->getDefinition('evrinoma.'.EvrinomaMailBundle::BUNDLE.'.command.manager');
            $commandManager->setArgument(3, $commandMediator);
        }
    }
}
