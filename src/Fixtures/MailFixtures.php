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

namespace Evrinoma\MailBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Entity\Mail\BaseMail;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class MailFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        0 => [
            MailApiDtoInterface::EMAIL => 'QWERT3601@test.ru',
            'created_at' => '2008-10-23 10:21:50',
        ],
        1 => [
            MailApiDtoInterface::EMAIL => 'qwert3602@test.com',
            'created_at' => '2015-10-23 10:21:50',
        ],
        2 => [
            MailApiDtoInterface::EMAIL => '3603@mail.ru',
            'created_at' => '2020-10-23 10:21:50',
        ],
        3 => [
            MailApiDtoInterface::EMAIL => '3604@mail.com',
            'created_at' => '2020-10-23 10:21:50',
        ],
        4 => [
            MailApiDtoInterface::EMAIL => '3605@google.ru',
            'created_at' => '2015-10-23 10:21:50',
        ],
        5 => [
            MailApiDtoInterface::EMAIL => '3606@google.com',
            'created_at' => '2010-10-23 10:21:50',
        ],
        6 => [
            MailApiDtoInterface::EMAIL => '3607@google.ru',
            'created_at' => '2010-10-23 10:21:50',
        ],
        7 => [
            MailApiDtoInterface::EMAIL => 'AqwW3608@google.com',
            'created_at' => '2011-10-23 10:21:50',
        ],
    ];

    protected static string $class = BaseMail::class;

    /**
     * @param ObjectManager $manager
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
    {
        $short = static::getReferenceName();
        $i = 0;

        foreach ($this->getData()  as $record) {
            /** @var BaseMail $entity */
            $entity = $this->getEntity();
            $entity
                ->setEmail($record[MailApiDtoInterface::EMAIL])
                ->setCreatedAt(new \DateTimeImmutable($record['created_at']));

            $this->expandEntity($entity, $record);

            $this->addReference($short.$i, $entity);
            $manager->persist($entity);
            ++$i;
        }

        return $this;
    }

    public static function getGroups(): array
    {
        return [
            FixtureInterface::MAIL_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 0;
    }
}
