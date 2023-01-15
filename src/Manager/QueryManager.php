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

namespace Evrinoma\MailBundle\Manager;

use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Exception\MailNotFoundException;
use Evrinoma\MailBundle\Exception\MailProxyException;
use Evrinoma\MailBundle\Model\Mail\MailInterface;
use Evrinoma\MailBundle\Repository\Mail\MailQueryRepositoryInterface;

final class QueryManager implements QueryManagerInterface
{
    private MailQueryRepositoryInterface $repository;

    public function __construct(MailQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param MailApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MailNotFoundException
     */
    public function criteria(MailApiDtoInterface $dto): array
    {
        try {
            $mail = $this->repository->findByCriteria($dto);
        } catch (MailNotFoundException $e) {
            throw $e;
        }

        return $mail;
    }

    /**
     * @param MailApiDtoInterface $dto
     *
     * @return MailInterface
     *
     * @throws MailProxyException
     */
    public function proxy(MailApiDtoInterface $dto): MailInterface
    {
        try {
            if ($dto->hasId()) {
                $mail = $this->repository->proxy($dto->idToString());
            } else {
                throw new MailProxyException('Id value is not set while trying get proxy object');
            }
        } catch (MailProxyException $e) {
            throw $e;
        }

        return $mail;
    }

    /**
     * @param MailApiDtoInterface $dto
     *
     * @return MailInterface
     *
     * @throws MailNotFoundException
     */
    public function get(MailApiDtoInterface $dto): MailInterface
    {
        try {
            $mail = $this->repository->find($dto->idToString());
        } catch (MailNotFoundException $e) {
            throw $e;
        }

        return $mail;
    }
}
