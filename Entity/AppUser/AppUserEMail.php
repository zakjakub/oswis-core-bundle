<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisCoreBundle\Entity\AppUser;

use ApiPlatform\Core\Annotation\ApiResource;
use OswisOrg\OswisCoreBundle\Entity\AbstractClass\AbstractEMail;
use OswisOrg\OswisCoreBundle\Entity\AbstractClass\AbstractToken;
use OswisOrg\OswisCoreBundle\Entity\NonPersistent\Nameable;
use OswisOrg\OswisCoreBundle\Exceptions\InvalidTypeException;
use OswisOrg\OswisCoreBundle\Exceptions\OswisException;
use OswisOrg\OswisCoreBundle\Filter\SearchAnnotation as Searchable;

/**
 * E-mail sent to some user.
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="OswisOrg\OswisCoreBundle\Repository\AppUserTokenRepository")
 * @Doctrine\ORM\Mapping\Table(name="core_app_user_token")
 * @ApiResource(
 *   attributes={
 *     "filters"={"search"},
 *     "access_control"="is_granted('ROLE_ADMIN')",
 *     "normalization_context"={"groups"={"app_user_roles_get"}, "enable_max_depth"=true},
 *     "denormalization_context"={"groups"={"app_user_roles_post"}, "enable_max_depth"=true}
 *   },
 *   collectionOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_ADMIN')",
 *       "normalization_context"={"groups"={"app_user_roles_get"}, "enable_max_depth"=true},
 *     },
 *     "post"={
 *       "access_control"="is_granted('ROLE_ADMIN')",
 *       "denormalization_context"={"groups"={"app_user_roles_post"}, "enable_max_depth"=true}
 *     }
 *   },
 *   itemOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_ADMIN')",
 *       "normalization_context"={"groups"={"app_user_role_get"}, "enable_max_depth"=true},
 *     },
 *     "put"={
 *       "access_control"="is_granted('ROLE_ADMIN')",
 *       "denormalization_context"={"groups"={"app_user_role_put"}, "enable_max_depth"=true}
 *     }
 *   }
 * )
 * @Searchable({
 *     "id",
 *     "token"
 * })
 * @author Jakub Zak <mail@jakubzak.eu>
 * @Doctrine\ORM\Mapping\Cache(usage="NONSTRICT_READ_WRITE", region="core_app_user")
 */
class AppUserEMail extends AbstractEMail
{
    /**
     * @Doctrine\ORM\Mapping\ManyToOne(targetEntity="OswisOrg\OswisCoreBundle\Entity\AppUser\AppUserToken", fetch="EAGER")
     * @Doctrine\ORM\Mapping\JoinColumn(name="app_user_id", referencedColumnName="id")
     */
    protected ?AppUser $appUser = null;

    /**
     * @Doctrine\ORM\Mapping\ManyToOne(targetEntity="OswisOrg\OswisCoreBundle\Entity\AppUser\AppUserToken", fetch="EAGER")
     * @Doctrine\ORM\Mapping\JoinColumn(name="app_user_token_id", referencedColumnName="id")
     */
    protected ?AppUserToken $appUserToken = null;

    /**
     * AppUserEMail constructor.
     *
     * @param Nameable|null $nameable
     * @param string|null   $eMail
     * @param string|null   $type
     *
     * @throws OswisException|InvalidTypeException
     */
    public function __construct(
        ?AppUser $appUser = null,
        ?Nameable $nameable = null,
        ?string $eMail = null,
        ?string $type = null,
        AppUserToken $token = null
    ) {
        parent::__construct($nameable, $eMail, $type);
        $this->setAppUserToken($token);
        $this->appUser = $appUser;
    }

    public function isAppUser(?AppUser $appUser): bool
    {
        return $this->getAppUser() === $appUser;
    }

    public function getAppUser(): ?AppUser
    {
        return $this->appUser;
    }

    /**
     * @param AppUser|null $appUser
     *
     * @throws OswisException
     */
    public function setAppUser(?AppUser $appUser): void
    {
        if (null === $appUser || null === $this->getAppUser()) {
            $this->appUser = $appUser;
        }
        throw new OswisException('nelze změnit uživatele u odeslaného e-mailu');
    }

    public function getAppUserToken(): ?AbstractToken
    {
        return $this->appUserToken;
    }

    /**
     * @param AppUserToken|null $appUserToken
     *
     * @throws OswisException
     */
    public function setAppUserToken(?AppUserToken $appUserToken): void
    {
        if (null === $appUserToken || null === $this->getAppUserToken()) {
            $this->appUserToken = $appUserToken;
        }
        throw new OswisException('nelze změnit přiřazený token u odeslaného e-mailu');
    }
}
