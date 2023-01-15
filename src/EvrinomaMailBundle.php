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

namespace Evrinoma\MailBundle;

use Evrinoma\MailBundle\DependencyInjection\Compiler\Constraint\Property\MailPass;
use Evrinoma\MailBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\MailBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\MailBundle\DependencyInjection\Compiler\ServicePass;
use Evrinoma\MailBundle\DependencyInjection\EvrinomaMailExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaMailBundle extends Bundle
{
    public const BUNDLE = 'mail';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new DecoratorPass())
            ->addCompilerPass(new ServicePass())
            ->addCompilerPass(new MailPass())
        ;
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaMailExtension();
        }

        return $this->extension;
    }
}
