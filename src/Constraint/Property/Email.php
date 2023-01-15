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

namespace Evrinoma\MailBundle\Constraint\Property;

use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;
use Symfony\Component\Validator\Constraints\Email as BaseEmail;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class Email implements ConstraintInterface
{
    public function getConstraints(): array
    {
        return [
            new NotBlank(),
            new NotNull(),
            new BaseEmail(),
        ];
    }

    public function getPropertyName(): string
    {
        return 'email';
    }
}
