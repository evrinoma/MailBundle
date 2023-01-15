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

namespace Evrinoma\MailBundle\PreValidator;

use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Exception\MailInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param MailApiDtoInterface $dto
     *
     * @throws MailInvalidException
     */
    public function onPost(MailApiDtoInterface $dto): void;

    /**
     * @param MailApiDtoInterface $dto
     *
     * @throws MailInvalidException
     */
    public function onPut(MailApiDtoInterface $dto): void;

    /**
     * @param MailApiDtoInterface $dto
     *
     * @throws MailInvalidException
     */
    public function onDelete(MailApiDtoInterface $dto): void;
}
