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

namespace Evrinoma\MailBundle\Repository\Mail;

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Exception\MailNotFoundException;
use Evrinoma\MailBundle\Exception\MailProxyException;
use Evrinoma\MailBundle\Model\Mail\MailInterface;

interface MailQueryRepositoryInterface
{
    /**
     * @param MailApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MailNotFoundException
     */
    public function findByCriteria(MailApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return MailInterface
     *
     * @throws MailNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): MailInterface;

    /**
     * @param string $id
     *
     * @return MailInterface
     *
     * @throws MailProxyException
     * @throws ORMException
     */
    public function proxy(string $id): MailInterface;
}
