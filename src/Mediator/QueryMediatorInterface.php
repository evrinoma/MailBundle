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

namespace Evrinoma\MailBundle\Mediator;

use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param MailApiDtoInterface   $dto
     * @param QueryBuilderInterface $builder
     *
     * @return mixed
     */
    public function createQuery(MailApiDtoInterface $dto, QueryBuilderInterface $builder): void;

    /**
     * @param MailApiDtoInterface   $dto
     * @param QueryBuilderInterface $builder
     *
     * @return array
     */
    public function getResult(MailApiDtoInterface $dto, QueryBuilderInterface $builder): array;
}
