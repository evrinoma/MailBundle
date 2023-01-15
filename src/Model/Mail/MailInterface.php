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

namespace Evrinoma\MailBundle\Model\Mail;

use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\EmailInterface as BaseEmailInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;

interface MailInterface extends CreateUpdateAtInterface, IdInterface, BaseEmailInterface
{
}
