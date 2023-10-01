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

namespace Evrinoma\MailBundle\Serializer;

interface GroupInterface
{
    public const API_POST_MAIL = 'API_POST_MAIL';
    public const API_PUT_MAIL = 'API_PUT_MAIL';
    public const API_DELETE_MAIL = 'API_DELETE_MAIL';
    public const API_GET_MAIL = 'API_GET_MAIL';
    public const API_CRITERIA_MAIL = self::API_GET_MAIL;
    public const APP_GET_BASIC_MAIL = 'APP_GET_BASIC_MAIL';
}
