<?php

namespace Zakjakub\OswisCoreBundle\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\Common\Collections\Collection;
use Zakjakub\OswisCoreBundle\Filter\SearchAnnotation as Searchable;
use Zakjakub\OswisCoreBundle\Traits\Entity\BasicEntityTrait;
use Zakjakub\OswisCoreBundle\Traits\Entity\NameableBasicTrait;

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @Doctrine\ORM\Mapping\Table(name="job_fair_user_flag")
 * @ApiResource()
 * @ApiFilter(OrderFilter::class)
 * @Searchable({
 *     "id",
 *     "name",
 *     "description",
 *     "note"
 * })
 */
class AppUserFlag
{
    use BasicEntityTrait;
    use NameableBasicTrait;

    /**
     * @var Collection|null
     * @Doctrine\ORM\Mapping\OneToMany(
     *     targetEntity="Zakjakub\OswisCoreBundle\Entity\AppUserFlagConnection",
     *     cascade={"all"},
     *     mappedBy="appUserFlag",
     *     fetch="EAGER"
     * )
     */
    protected $appUserFlagConnections;

    public function __construct(
        ?Nameable $nameable = null
    ) {
        $this->appUserFlagConnections = new ArrayCollection();
        $this->setFieldsFromNameable($nameable);
    }

    final public function getAppUserFlagConnections(): Collection
    {
        return $this->appUserFlagConnections;
    }

    final public function addAppUserFlagConnection(?AppUserFlagConnection $appUserFlagConnection): void
    {
        if ($appUserFlagConnection && !$this->appUserFlagConnections->contains($appUserFlagConnection)) {
            $this->appUserFlagConnections->add($appUserFlagConnection);
            $appUserFlagConnection->setAppUserFlag($this);
        }
    }

    final public function removeAppUserFlagConnection(?AppUserFlagConnection $appUserFlagConnection): void
    {
        if (!$appUserFlagConnection) {
            return;
        }
        if ($this->appUserFlagConnections->removeElement($appUserFlagConnection)) {
            $appUserFlagConnection->setAppUserFlag(null);
        }
    }
}