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

namespace Evrinoma\MailBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\EmailInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface MailApiDtoInterface extends DtoInterface, IdInterface, EmailInterface
{
    public const MAIL = 'mail';
    public const MAILS = MailApiDtoInterface::MAIL.'s';
}
