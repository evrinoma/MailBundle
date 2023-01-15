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

use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Exception\MailCannotBeCreatedException;
use Evrinoma\MailBundle\Exception\MailCannotBeRemovedException;
use Evrinoma\MailBundle\Exception\MailCannotBeSavedException;
use Evrinoma\MailBundle\Model\Mail\MailInterface;

interface CommandMediatorInterface
{
    /**
     * @param MailApiDtoInterface $dto
     * @param MailInterface       $entity
     *
     * @return MailInterface
     *
     * @throws MailCannotBeSavedException
     */
    public function onUpdate(MailApiDtoInterface $dto, MailInterface $entity): MailInterface;

    /**
     * @param MailApiDtoInterface $dto
     * @param MailInterface       $entity
     *
     * @throws MailCannotBeRemovedException
     */
    public function onDelete(MailApiDtoInterface $dto, MailInterface $entity): void;

    /**
     * @param MailApiDtoInterface $dto
     * @param MailInterface       $entity
     *
     * @return MailInterface
     *
     * @throws MailCannotBeSavedException
     * @throws MailCannotBeCreatedException
     */
    public function onCreate(MailApiDtoInterface $dto, MailInterface $entity): MailInterface;
}
