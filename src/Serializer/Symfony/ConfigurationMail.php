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

namespace Evrinoma\MailBundle\Serializer\Symfony;

use Evrinoma\UtilsBundle\Serialize\AbstractConfiguration;

class ConfigurationMail extends AbstractConfiguration
{
    protected string $fileName = '/src/Resources/serializer/Symfony/serializer/MailBundle/Model.Mail.AbstractMail.yml';
}
