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
use Symfony\Component\HttpFoundation\Request;

trait MailsApiDtoTrait
{
    protected array $mailsApiDto = [];

    public function hasMailsApiDto(): bool
    {
        return 0 !== \count($this->mailsApiDto);
    }

    public function getMailsApiDto(): array
    {
        return $this->mailsApiDto;
    }

    public function genRequestMailsApiDto(?Request $request): ?\Generator
    {
        if ($request) {
            $entities = $request->get(MailsApiDtoInterface::MAILS);
            if ($entities) {
                foreach ($entities as $entity) {
                    $newRequest = $this->getCloneRequest();
                    $entity[DtoInterface::DTO_CLASS] = MailApiDto::class;
                    $newRequest->request->add($entity);

                    yield $newRequest;
                }
            }
        }
    }
}
