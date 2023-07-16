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

namespace Evrinoma\MailBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\MailBundle\Dto\MailApiDtoInterface;
use Evrinoma\MailBundle\Exception\MailCannotBeSavedException;
use Evrinoma\MailBundle\Exception\MailInvalidException;
use Evrinoma\MailBundle\Exception\MailNotFoundException;
use Evrinoma\MailBundle\Facade\Mail\FacadeInterface;
use Evrinoma\MailBundle\Serializer\GroupInterface;
use Evrinoma\UtilsBundle\Controller\AbstractWrappedApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use Evrinoma\UtilsBundle\Serialize\SerializerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class MailApiController extends AbstractWrappedApiController implements ApiControllerInterface
{
    private string $dtoClass;

    private ?Request $request;

    private FactoryDtoInterface $factoryDto;

    private FacadeInterface $facade;

    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        FacadeInterface $facade,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->dtoClass = $dtoClass;
        $this->facade = $facade;
    }

    /**
     * @Rest\Post("/api/mail/create", options={"expose": true}, name="api_mail_create")
     * @OA\Post(
     *     tags={"mail"},
     *     description="the method perform create mail",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\MailBundle\Dto\MailApiDto",
     *                     "email": "test@test.com",
     *                 },
     *                 type="object",
     *                 @OA\Property(property="class", type="string", default="Evrinoma\MailBundle\Dto\MailApiDto"),
     *                 @OA\Property(property="email", type="string"),
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Create mail")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var MailApiDtoInterface $mailApiDto */
        $mailApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusCreated();

        $json = [];
        $error = [];
        $group = GroupInterface::API_POST_MAIL;

        try {
            $this->facade->post($mailApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Create mail', $json, $error);
    }

    /**
     * @Rest\Put("/api/mail/save", options={"expose": true}, name="api_mail_save")
     * @OA\Put(
     *     tags={"mail"},
     *     description="the method perform save mail for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\MailBundle\Dto\MailApiDto",
     *                     "id": "2",
     *                     "email": "test@test.com",
     *                 },
     *                 type="object",
     *                 @OA\Property(property="class", type="string", default="Evrinoma\MailBundle\Dto\MailApiDto"),
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Save mail")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var MailApiDtoInterface $mailApiDto */
        $mailApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_PUT_MAIL;

        try {
            $this->facade->put($mailApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Save mail', $json, $error);
    }

    /**
     * @Rest\Delete("/api/mail/delete", options={"expose": true}, name="api_mail_delete")
     * @OA\Delete(
     *     tags={"mail"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\MailBundle\Dto\MailApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Delete mail")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var MailApiDtoInterface $mailApiDto */
        $mailApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusAccepted();

        $json = [];
        $error = [];

        try {
            $this->facade->delete($mailApiDto, '', $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->JsonResponse('Delete mail', $json, $error);
    }

    /**
     * @Rest\Get("/api/mail/criteria", options={"expose": true}, name="api_mail_criteria")
     * @OA\Get(
     *     tags={"mail"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\MailBundle\Dto\MailApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="email",
     *         in="query",
     *         name="email",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     * )
     * @OA\Response(response=200, description="Return mail")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var MailApiDtoInterface $mailApiDto */
        $mailApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_CRITERIA_MAIL;

        try {
            $this->facade->criteria($mailApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get mail', $json, $error);
    }

    /**
     * @Rest\Get("/api/mail", options={"expose": true}, name="api_mail")
     * @OA\Get(
     *     tags={"mail"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\MailBundle\Dto\MailApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return mail")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var MailApiDtoInterface $mailApiDto */
        $mailApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_GET_MAIL;

        try {
            $this->facade->get($mailApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get mail', $json, $error);
    }

    /**
     * @param \Exception $e
     *
     * @return array
     */
    public function setRestStatus(\Exception $e): array
    {
        switch (true) {
            case $e instanceof MailCannotBeSavedException:
                $this->setStatusNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $this->setStatusConflict();
                break;
            case $e instanceof MailNotFoundException:
                $this->setStatusNotFound();
                break;
            case $e instanceof MailInvalidException:
                $this->setStatusUnprocessableEntity();
                break;
            default:
                $this->setStatusBadRequest();
        }

        return [$e->getMessage()];
    }
}
