<?php /** @noinspection MethodShouldBeFinalInspection */

namespace Zakjakub\OswisCoreBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Zakjakub\OswisCoreBundle\Entity\AppUserRole;
use Zakjakub\OswisCoreBundle\Repository\AppUserRoleRepository;

/**
 * AppUserRole service.
 * @noinspection PhpUnused
 */
class AppUserRoleService
{
    protected EntityManagerInterface $em;

    protected ?LoggerInterface $logger;

    public function __construct(EntityManagerInterface $em, ?LoggerInterface $logger = null)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function create(AppUserRole $role): AppUserRole
    {
        $existing = $this->getRepository()->findBySlug($role->getSlug());
        if (null === $existing || !($existing instanceof AppUserRole)) {
            $this->em->persist($role);
        }
        $this->em->flush();

        return $role;
    }

    public function getRepository(): AppUserRoleRepository
    {
        $repo = $this->em->getRepository(AppUserRole::class);
        assert($repo instanceof AppUserRoleRepository);

        return $repo;
    }
}
