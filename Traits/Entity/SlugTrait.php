<?php

namespace Zakjakub\OswisCoreBundle\Traits\Entity;

/**
 * Trait adds slug field.
 */
trait SlugTrait
{

    /**
     * Slug.
     * @var string|null
     *
     * @Doctrine\ORM\Mapping\Column(nullable=true)
     */
    protected ?string $slug;


    /**
     * Get slug.
     * @return string|null
     */
    final public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set slug.
     *
     * @param null|string $slug
     */
    final public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }
}
