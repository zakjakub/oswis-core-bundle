<?php
/** @noinspection PhpDocRedundantThrowsInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Zakjakub\OswisCoreBundle\Traits\Entity;

use Zakjakub\OswisCoreBundle\Exceptions\RevisionMissingException;

/**
 * Trait adds getters and setters for container of entity with nameable fields.
 */
trait NameableBasicContainerTrait
{

    /**
     * @param string|null $name
     *
     * @throws RevisionMissingException
     */
    final public function setName(?string $name): void
    {
        if ($this->getName() !== $name) {
            $newRevision = clone $this->getRevision();
            $newRevision->setName($name);
            $this->addRevision($newRevision);
        }
    }

    final public function getName(?\DateTime $dateTime = null): ?string
    {
        return $this->getRevisionByDate($dateTime)->getName();
    }

    /**
     * @param string|null $shortName
     *
     * @throws RevisionMissingException
     */
    final public function setShortName(?string $shortName): void
    {
        if ($this->getShortName() !== $shortName) {
            $newRevision = clone $this->getRevision();
            $newRevision->setShortName($shortName);
            $this->addRevision($newRevision);
        }
    }

    final public function getShortName(?\DateTime $dateTime = null): ?string
    {
        return $this->getRevisionByDate($dateTime)->getShortName();
    }

    /**
     * @param string|null $description
     *
     * @throws RevisionMissingException
     */
    final public function setDescription(?string $description): void
    {
        if ($this->getDescription() !== $description) {
            $newRevision = clone $this->getRevision();
            $newRevision->setDescription($description);
            $this->addRevision($newRevision);
        }
    }

    final public function getDescription(?\DateTime $dateTime = null): ?string
    {
        return $this->getRevisionByDate($dateTime)->getDescription();
    }

    /**
     * @param string|null $note
     *
     * @throws RevisionMissingException
     */
    final public function setNote(?string $note): void
    {
        if ($this->getNote() !== $note) {
            $newRevision = clone $this->getRevision();
            $newRevision->setNote($note);
            $this->addRevision($newRevision);
        }
    }

    final public function getNote(?\DateTime $dateTime = null): ?string
    {
        return $this->getRevisionByDate($dateTime)->getNote();
    }
}
