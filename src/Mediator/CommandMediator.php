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

namespace Evrinoma\MailBundle\Mediator;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Model\Mail\MailInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    public function onUpdate(DtoInterface $dto, $entity): MailInterface
    {
        /* @var $dto MailApiDtoInterface */
        $entity
            ->setEmail($dto->getEmail())
            ->setUpdatedAt(new \DateTimeImmutable());

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
    }

    public function onCreate(DtoInterface $dto, $entity): MailInterface
    {
        /* @var $dto MailApiDtoInterface */
        $entity
            ->setEmail($dto->getEmail())
            ->setCreatedAt(new \DateTimeImmutable());

        return $entity;
    }
}
