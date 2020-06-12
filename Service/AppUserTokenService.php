<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisCoreBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use OswisOrg\OswisCoreBundle\Entity\AppUser\AppUser;
use OswisOrg\OswisCoreBundle\Entity\AppUser\AppUserToken;
use OswisOrg\OswisCoreBundle\Exceptions\InvalidTypeException;
use OswisOrg\OswisCoreBundle\Repository\AppUserTokenRepository;
use Psr\Log\LoggerInterface;

/**
 * AppUserRole service.
 * @noinspection PhpUnused
 */
class AppUserTokenService
{
    protected EntityManagerInterface $em;

    protected LoggerInterface $logger;

    protected AppUserService $appUserService;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, AppUserService $appUserService)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->appUserService = $appUserService;
    }

    /**
     * @param AppUser     $appUser
     * @param string|null $type
     * @param bool|null   $multipleUseAllowed
     * @param int|null    $validHours
     *
     * @return AppUserToken
     * @throws InvalidTypeException
     */
    public function create(AppUser $appUser, ?string $type = null, ?bool $multipleUseAllowed = null, ?int $validHours = null): AppUserToken
    {
        try {
            $appUserToken = new AppUserToken($appUser, $appUser->getEmail(), $type, $multipleUseAllowed, $validHours);
            $this->em->persist($appUserToken);
            $this->em->flush();
            $tokenId = $appUserToken->getId();
            $appUserId = $appUser->getId();
            $this->logger->info("Created new token ($tokenId) of type '$type' for user '$appUserId'.");

            return $appUserToken;
        } catch (InvalidTypeException $exception) {
            $this->logger->error($exception->getMessage());
            throw $exception;
        }
    }

    public function getRepository(): AppUserTokenRepository
    {
        $repo = $this->em->getRepository(AppUserToken::class);
        assert($repo instanceof AppUserTokenRepository);

        return $repo;
    }
}
