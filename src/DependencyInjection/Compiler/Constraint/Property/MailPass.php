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

namespace Evrinoma\MailBundle\DependencyInjection\Compiler\Constraint\Property;

use Evrinoma\MailBundle\Validator\MailValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class MailPass extends AbstractConstraint implements CompilerPassInterface
{
    public const MAIL_CONSTRAINT = 'evrinoma.mail.constraint.property';

    protected static string $alias = self::MAIL_CONSTRAINT;
    protected static string $class = MailValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}
