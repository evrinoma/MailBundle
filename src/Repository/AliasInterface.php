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

namespace Evrinoma\MailBundle\Repository;

interface AliasInterface
{
    public const MAIL = 'mail';
    public const MAILS = AliasInterface::MAIL.'s';
}
