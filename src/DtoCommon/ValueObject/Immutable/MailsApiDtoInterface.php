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

namespace Evrinoma\MailBundle\DtoCommon\ValueObject\Immutable;

use Evrinoma\MailBundle\Dto\MailApiDtoInterface as BaseMailApiDtoInterface;

interface MailsApiDtoInterface
{
    public const MAILS = BaseMailApiDtoInterface::MAILS;

    public function hasMailsApiDto(): bool;

    public function getMailsApiDto(): array;
}
