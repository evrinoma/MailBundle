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

namespace Evrinoma\MailBundle\Manager;

use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Exception\MailNotFoundException;
use Evrinoma\MailBundle\Exception\MailProxyException;
use Evrinoma\MailBundle\Model\Mail\MailInterface;

interface QueryManagerInterface
{
    /**
     * @param MailApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MailNotFoundException
     */
    public function criteria(MailApiDtoInterface $dto): array;

    /**
     * @param MailApiDtoInterface $dto
     *
     * @return MailInterface
     *
     * @throws MailNotFoundException
     */
    public function get(MailApiDtoInterface $dto): MailInterface;

    /**
     * @param MailApiDtoInterface $dto
     *
     * @return MailInterface
     *
     * @throws MailProxyException
     */
    public function proxy(MailApiDtoInterface $dto): MailInterface;
}
