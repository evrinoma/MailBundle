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

namespace Evrinoma\MailBundle\Tests\Functional\Helper;

use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

trait BaseMailTestTrait
{
    protected function assertGet(string $id): array
    {
        $find = $this->get($id);
        $this->testResponseStatusOK();

        $this->checkResult($find);

        return $find;
    }

    protected function createMail(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function createConstraintBlankEmail(): array
    {
        $query = static::getDefault([MailApiDtoInterface::EMAIL => '']);

        return $this->post($query);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $entity);
        Assert::assertCount(1, $entity[PayloadModel::PAYLOAD]);
        $this->checkMail($entity[PayloadModel::PAYLOAD][0]);
    }

    protected function checkMail($entity): void
    {
        Assert::assertArrayHasKey(MailApiDtoInterface::ID, $entity);
        Assert::assertArrayHasKey(MailApiDtoInterface::EMAIL, $entity);
    }
}
