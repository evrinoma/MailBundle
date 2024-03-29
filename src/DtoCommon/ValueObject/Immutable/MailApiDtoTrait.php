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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MailBundle\Dto\MailApiDto;
use Evrinoma\MailBundle\Dto\MailApiDtoInterface as BaseMailApiDtoInterface;
use Symfony\Component\HttpFoundation\Request;

trait MailApiDtoTrait
{
    protected ?BaseMailApiDtoInterface $mailApiDto = null;

    protected static string $classMailApiDto = MailApiDto::class;

    public function genRequestMailApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $mail = $request->get(MailApiDtoInterface::MAIL);
            if ($mail) {
                yield $this->toRequest($mail, static::$classMailApiDto);
            }
        }
    }

    public function hasMailApiDto(): bool
    {
        return null !== $this->mailApiDto;
    }

    public function getMailApiDto(): BaseMailApiDtoInterface
    {
        return $this->mailApiDto;
    }
}
