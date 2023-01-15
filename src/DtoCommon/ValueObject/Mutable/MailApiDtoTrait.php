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

namespace Evrinoma\MailBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\DtoCommon\ValueObject\Immutable\MailApiDtoTrait as MailApiDtoImmutableTrait;

trait MailApiDtoTrait
{
    use MailApiDtoImmutableTrait;

    public function setMailApiDto(MailApiDtoInterface $mailApiDto): DtoInterface
    {
        $this->mailApiDto = $mailApiDto;

        return $this;
    }
}
