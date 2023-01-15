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

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\EmailTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;

/**
 * @ORM\MappedSuperclass
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_mail", columns={"email"})})
 */
abstract class AbstractMail implements MailInterface
{
    use CreateUpdateAtTrait;
    use EmailTrait;
    use IdTrait;
}
