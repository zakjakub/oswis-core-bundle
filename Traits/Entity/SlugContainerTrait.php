<?php
/** @noinspection PhpUndefinedMethodInspection */

namespace Zakjakub\OswisCoreBundle\Traits\Entity;

trait SlugContainerTrait
{

    /**
     * @param string|null $slug
     *
     * @throws RevisionMissingException
     */
    final public function setSlug(?string $slug): void
    {
        if ($this->getSlug() !== $slug) {
            $newRevision = clone $this->getRevision();
            $newRevision->setSlug($slug);
            $this->addRevision($newRevision);
        }
    }

    final public function getSlug(?\DateTime $dateTime = null): ?string
    {
        return $this->getRevisionByDate($dateTime)->getSlug();
    }
}