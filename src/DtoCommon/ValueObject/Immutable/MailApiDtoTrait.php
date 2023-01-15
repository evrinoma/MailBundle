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

    public function genRequestMailApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $mail = $request->get(MailApiDtoInterface::MAIL);
            if ($mail) {
                $newRequest = $this->getCloneRequest();
                $mail[DtoInterface::DTO_CLASS] = MailApiDto::class;
                $newRequest->request->add($mail);

                yield $newRequest;
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
