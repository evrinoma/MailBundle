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

namespace Evrinoma\MailBundle\Tests\Functional\Action;

use Evrinoma\MailBundle\Dto\MailApiDto;
use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Tests\Functional\Helper\BaseMailTestTrait;
use Evrinoma\MailBundle\Tests\Functional\ValueObject\Mail\Email;
use Evrinoma\MailBundle\Tests\Functional\ValueObject\Mail\Id;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

class BaseMail extends AbstractServiceTest implements BaseMailTestInterface
{
    use BaseMailTestTrait;

    public const API_GET = 'evrinoma/api/mail';
    public const API_CRITERIA = 'evrinoma/api/mail/criteria';
    public const API_DELETE = 'evrinoma/api/mail/delete';
    public const API_PUT = 'evrinoma/api/mail/save';
    public const API_POST = 'evrinoma/api/mail/create';

    protected static function getDtoClass(): string
    {
        return MailApiDto::class;
    }

    protected static function defaultData(): array
    {
        return [
            MailApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            MailApiDtoInterface::ID => Id::value(),
            MailApiDtoInterface::EMAIL => Email::value(),
        ];
    }

    public function actionPost(): void
    {
        $created = $this->createMail();
        $this->testResponseStatusCreated();
    }

    public function actionCriteriaNotFound(): void
    {
        $find = $this->criteria([MailApiDtoInterface::DTO_CLASS => static::getDtoClass(), MailApiDtoInterface::ID => Id::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);

        $find = $this->criteria([MailApiDtoInterface::DTO_CLASS => static::getDtoClass(), MailApiDtoInterface::ID => Id::value(), MailApiDtoInterface::EMAIL => Email::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);
    }

    public function actionCriteria(): void
    {
        $find = $this->criteria([MailApiDtoInterface::DTO_CLASS => static::getDtoClass(), MailApiDtoInterface::ID => Id::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(1, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([MailApiDtoInterface::DTO_CLASS => static::getDtoClass(),  MailApiDtoInterface::EMAIL => Email::DOMAIN()]);
        $this->testResponseStatusOK();
        Assert::assertCount(2, $find[PayloadModel::PAYLOAD]);
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(Id::value());

        $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->get(Id::value());
        $this->testResponseStatusNotFound();
    }

    public function actionPut(): void
    {
        $find = $this->assertGet(Id::value());

        $updated = $this->put(static::getDefault([MailApiDtoInterface::ID => Id::value(), MailApiDtoInterface::EMAIL => Email::value()]));
        $this->testResponseStatusOK();

        Assert::assertEquals($find[PayloadModel::PAYLOAD][0][MailApiDtoInterface::ID], $updated[PayloadModel::PAYLOAD][0][MailApiDtoInterface::ID]);
        Assert::assertEquals(Email::value(), $updated[PayloadModel::PAYLOAD][0][MailApiDtoInterface::EMAIL]);
    }

    public function actionGet(): void
    {
        $find = $this->assertGet(Id::value());
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $response = $this->delete(Id::empty());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutNotFound(): void
    {
        $this->put(static::getDefault([
            MailApiDtoInterface::ID => Id::wrong(),
            MailApiDtoInterface::EMAIL => Email::wrong(),
        ]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $created = $this->createMail();
        $this->testResponseStatusCreated();
        $this->checkResult($created);

        $query = static::getDefault([MailApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][MailApiDtoInterface::ID], MailApiDtoInterface::EMAIL => Email::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostDuplicate(): void
    {
        $this->createMail();
        $this->testResponseStatusCreated();
        $this->createMail();
        $this->testResponseStatusConflict();
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankEmail();
        $this->testResponseStatusUnprocessable();
    }
}
