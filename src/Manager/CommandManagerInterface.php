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

namespace Evrinoma\MailBundle\Manager;

use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Exception\MailCannotBeRemovedException;
use Evrinoma\MailBundle\Exception\MailInvalidException;
use Evrinoma\MailBundle\Exception\MailNotFoundException;
use Evrinoma\MailBundle\Model\Mail\MailInterface;

interface CommandManagerInterface
{
    /**
     * @param MailApiDtoInterface $dto
     *
     * @return MailInterface
     *
     * @throws MailInvalidException
     */
    public function post(MailApiDtoInterface $dto): MailInterface;

    /**
     * @param MailApiDtoInterface $dto
     *
     * @return MailInterface
     *
     * @throws MailInvalidException
     * @throws MailNotFoundException
     */
    public function put(MailApiDtoInterface $dto): MailInterface;

    /**
     * @param MailApiDtoInterface $dto
     *
     * @throws MailCannotBeRemovedException
     * @throws MailNotFoundException
     */
    public function delete(MailApiDtoInterface $dto): void;
}
