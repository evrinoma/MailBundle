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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Exception\MailInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this
            ->checkMail($dto)
        ;
    }

    public function onPut(DtoInterface $dto): void
    {
        $this
            ->checkId($dto)
            ->checkMail($dto)
        ;
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this->checkId($dto);
    }

    private function checkMail(DtoInterface $dto): self
    {
        /** @var MailApiDtoInterface $dto */
        if (!$dto->hasEmail()) {
            throw new MailInvalidException('The Dto has\'t email');
        }

        return $this;
    }

    private function checkId(DtoInterface $dto): self
    {
        /** @var MailApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new MailInvalidException('The Dto has\'t ID or class invalid');
        }

        return $this;
    }
}
