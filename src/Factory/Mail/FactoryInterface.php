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

namespace Evrinoma\MailBundle\Factory\Mail;

use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Model\Mail\MailInterface;

interface FactoryInterface
{
    /**
     * @param MailApiDtoInterface $dto
     *
     * @return MailInterface
     */
    public function create(MailApiDtoInterface $dto): MailInterface;
}
