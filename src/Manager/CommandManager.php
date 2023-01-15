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
use Evrinoma\MailBundle\Exception\MailCannotBeCreatedException;
use Evrinoma\MailBundle\Exception\MailCannotBeRemovedException;
use Evrinoma\MailBundle\Exception\MailCannotBeSavedException;
use Evrinoma\MailBundle\Exception\MailInvalidException;
use Evrinoma\MailBundle\Exception\MailNotFoundException;
use Evrinoma\MailBundle\Factory\Mail\FactoryInterface;
use Evrinoma\MailBundle\Mediator\CommandMediatorInterface;
use Evrinoma\MailBundle\Model\Mail\MailInterface;
use Evrinoma\MailBundle\Repository\Mail\MailRepositoryInterface;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface
{
    private MailRepositoryInterface $repository;
    private ValidatorInterface            $validator;
    private FactoryInterface           $factory;
    private CommandMediatorInterface      $mediator;

    /**
     * @param ValidatorInterface       $validator
     * @param MailRepositoryInterface  $repository
     * @param FactoryInterface         $factory
     * @param CommandMediatorInterface $mediator
     */
    public function __construct(ValidatorInterface $validator, MailRepositoryInterface $repository, FactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mediator = $mediator;
    }

    /**
     * @param MailApiDtoInterface $dto
     *
     * @return MailInterface
     *
     * @throws MailInvalidException
     * @throws MailCannotBeCreatedException
     * @throws MailCannotBeSavedException
     */
    public function post(MailApiDtoInterface $dto): MailInterface
    {
        $mail = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $mail);

        $errors = $this->validator->validate($mail);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new MailInvalidException($errorsString);
        }

        $this->repository->save($mail);

        return $mail;
    }

    /**
     * @param MailApiDtoInterface $dto
     *
     * @return MailInterface
     *
     * @throws MailInvalidException
     * @throws MailNotFoundException
     * @throws MailCannotBeSavedException
     */
    public function put(MailApiDtoInterface $dto): MailInterface
    {
        try {
            $mail = $this->repository->find($dto->idToString());
        } catch (MailNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $mail);

        $errors = $this->validator->validate($mail);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new MailInvalidException($errorsString);
        }

        $this->repository->save($mail);

        return $mail;
    }

    /**
     * @param MailApiDtoInterface $dto
     *
     * @throws MailCannotBeRemovedException
     * @throws MailNotFoundException
     */
    public function delete(MailApiDtoInterface $dto): void
    {
        try {
            $mail = $this->repository->find($dto->idToString());
        } catch (MailNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $mail);
        try {
            $this->repository->remove($mail);
        } catch (MailCannotBeRemovedException $e) {
            throw $e;
        }
    }
}
