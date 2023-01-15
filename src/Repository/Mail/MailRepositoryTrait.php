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

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Exception\MailCannotBeRemovedException;
use Evrinoma\MailBundle\Exception\MailCannotBeSavedException;
use Evrinoma\MailBundle\Exception\MailNotFoundException;
use Evrinoma\MailBundle\Exception\MailProxyException;
use Evrinoma\MailBundle\Mediator\QueryMediatorInterface;
use Evrinoma\MailBundle\Model\Mail\MailInterface;

trait MailRepositoryTrait
{
    private QueryMediatorInterface $mediator;

    /**
     * @param MailInterface $mail
     *
     * @return bool
     *
     * @throws MailCannotBeSavedException
     * @throws ORMException
     */
    public function save(MailInterface $mail): bool
    {
        try {
            $this->persistWrapped($mail);
        } catch (ORMInvalidArgumentException $e) {
            throw new MailCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param MailInterface $mail
     *
     * @return bool
     */
    public function remove(MailInterface $mail): bool
    {
        try {
            $this->getEntityManager()->remove($mail);
        } catch (ORMInvalidArgumentException $e) {
            throw new MailCannotBeRemovedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param MailApiDtoInterface $dto
     *
     * @return array
     *
     * @throws MailNotFoundException
     */
    public function findByCriteria(MailApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilderWrapped($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $mails = $this->mediator->getResult($dto, $builder);

        if (0 === \count($mails)) {
            throw new MailNotFoundException('Cannot find mail by findByCriteria');
        }

        return $mails;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     *
     * @throws MailNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): MailInterface
    {
        /** @var MailInterface $mail */
        $mail = $this->findWrapped($id);

        if (null === $mail) {
            throw new MailNotFoundException("Cannot find mail with id $id");
        }

        return $mail;
    }

    /**
     * @param string $id
     *
     * @return MailInterface
     *
     * @throws MailProxyException
     * @throws ORMException
     */
    public function proxy(string $id): MailInterface
    {
        $mail = $this->referenceWrapped($id);

        if (!$this->containsWrapped($mail)) {
            throw new MailProxyException("Proxy doesn't exist with $id");
        }

        return $mail;
    }
}
