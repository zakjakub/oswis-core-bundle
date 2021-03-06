<?php

namespace OswisOrg\OswisCoreBundle\Api\Dto;

use ApiPlatform\Core\Annotation\ApiResource;
use OswisOrg\OswisCoreBundle\Entity\AppUser\AppUser;
use OswisOrg\OswisCoreBundle\Service\AppUserService;

/**
 * Endpoint for actions with users (activation, password changes...).
 * @ApiResource(
 *      collectionOperations={
 *          "post"={
 *              "path"="/app_user_action",
 *          },
 *      },
 *      itemOperations={},
 *      output=false
 * )
 * @todo Implement this class!!!
 */
final class AppUserActionRequest
{
    public const ALLOWED_TYPES = AppUserService::ALLOWED_TYPES;

    /**
     * ID of changed user.
     * ID has higher priority than username/e-mail.
     */
    public ?int $uid = null;

    /**
     * Username or e-mail of changed user.
     * ID has higher priority than username/e-mail.
     */
    public ?string $username = null;

    /**
     * Token generated when request was created.
     */
    public ?string $token = null;

    /**
     * New password.
     */
    public ?string $password = null;

    /**
     * Form of action.
     * @Symfony\Component\Validator\Constraints\Choice(
     *     choices=AppUserActionRequest::ALLOWED_TYPES,
     *     message="Požadovaný typ akce není implementovaný."
     * )
     */
    public ?string $type = null;

    /**
     * App user to change.
     */
    public ?AppUser $appUser = null;
}
