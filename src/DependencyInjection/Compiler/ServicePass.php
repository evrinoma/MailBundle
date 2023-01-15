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

class ServicePass extends AbstractRecursivePass
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $servicePreValidator = $container->hasParameter('evrinoma.'.EvrinomaMailBundle::BUNDLE.'.services.pre.validator');
        if ($servicePreValidator) {
            $servicePreValidator = $container->getParameter('evrinoma.'.EvrinomaMailBundle::BUNDLE.'.services.pre.validator');
            $preValidator = $container->getDefinition($servicePreValidator);
            $facade = $container->getDefinition('evrinoma.'.EvrinomaMailBundle::BUNDLE.'.facade');
            $facade->setArgument(3, $preValidator);
        }
        $serviceHandler = $container->hasParameter('evrinoma.'.EvrinomaMailBundle::BUNDLE.'.services.handler');
        if ($serviceHandler) {
            $serviceHandler = $container->getParameter('evrinoma.'.EvrinomaMailBundle::BUNDLE.'.services.handler');
            $handler = $container->getDefinition($serviceHandler);
            $facade = $container->getDefinition('evrinoma.'.EvrinomaMailBundle::BUNDLE.'.facade');
            $facade->setArgument(4, $handler);
        }
    }
}
