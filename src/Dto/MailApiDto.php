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

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\EmailTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Symfony\Component\HttpFoundation\Request;

class MailApiDto extends AbstractDto implements MailApiDtoInterface
{
    use EmailTrait;
    use IdTrait;

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id = $request->get(MailApiDtoInterface::ID);
            $email = $request->get(MailApiDtoInterface::EMAIL);

            if ($id) {
                $this->setId($id);
            }
            if ($email) {
                $this->setEmail(mb_strtolower($email));
            }
        }

        return $this;
    }
}
