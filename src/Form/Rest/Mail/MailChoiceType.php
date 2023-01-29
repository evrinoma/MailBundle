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

namespace Evrinoma\MailBundle\Form\Rest\Mail;

use Doctrine\DBAL\Exception\TableNotFoundException;
use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Exception\MailNotFoundException;
use Evrinoma\MailBundle\Manager\QueryManagerInterface;
use Evrinoma\UtilsBundle\Form\Rest\RestChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailChoiceType extends AbstractType
{
    protected static string $dtoClass;

    private QueryManagerInterface $queryManager;

    public function __construct(QueryManagerInterface $queryManager, string $dtoClass)
    {
        $this->queryManager = $queryManager;
        static::$dtoClass = $dtoClass;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $callback = function (Options $options) {
            $value = [];
            try {
                if ($options->offsetExists('data')) {
                    $criteria = $this->queryManager->criteria(new static::$dtoClass());
                    switch ($options->offsetGet('data')) {
                        case MailApiDtoInterface::EMAIL:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getMail();
                            }
                            break;
                        default:
                            foreach ($criteria as $entity) {
                                $value[] = $entity->getId();
                            }
                    }
                } else {
                    throw new MailNotFoundException();
                }
            } catch (TableNotFoundException|MailNotFoundException $e) {
                $value = RestChoiceType::REST_CHOICES_DEFAULT;
            }

            return $value;
        };
        $resolver->setDefault(RestChoiceType::REST_COMPONENT_NAME, 'mail');
        $resolver->setDefault(RestChoiceType::REST_DESCRIPTION, 'mailList');
        $resolver->setDefault(RestChoiceType::REST_CHOICES, $callback);
    }

    public function getParent()
    {
        return RestChoiceType::class;
    }
}
