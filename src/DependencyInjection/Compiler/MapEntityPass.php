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

use Evrinoma\MailBundle\DependencyInjection\EvrinomaMailExtension;
use Evrinoma\MailBundle\Model\Mail\MailInterface;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractMapEntity;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass extends AbstractMapEntity implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ('orm' === $container->getParameter('evrinoma.mail.storage')) {
            $this->setContainer($container);

            $driver = $container->findDefinition('doctrine.orm.default_metadata_driver');
            $referenceAnnotationReader = new Reference('annotations.reader');

            $this->cleanMetadata($driver, [EvrinomaMailExtension::ENTITY]);

            $entityMail = $container->getParameter('evrinoma.mail.entity');
            if (str_contains($entityMail, EvrinomaMailExtension::ENTITY)) {
                $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Mail', '%s/Entity/Mail');
            }
            $this->addResolveTargetEntity([$entityMail => [MailInterface::class => []]], false);
        }
    }
}
