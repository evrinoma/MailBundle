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

use Evrinoma\MailBundle\Exception\MailCannotBeRemovedException;
use Evrinoma\MailBundle\Exception\MailCannotBeSavedException;
use Evrinoma\MailBundle\Model\Mail\MailInterface;

interface MailCommandRepositoryInterface
{
    /**
     * @param MailInterface $mail
     *
     * @return bool
     *
     * @throws MailCannotBeSavedException
     */
    public function save(MailInterface $mail): bool;

    /**
     * @param MailInterface $mail
     *
     * @return bool
     *
     * @throws MailCannotBeRemovedException
     */
    public function remove(MailInterface $mail): bool;
}
