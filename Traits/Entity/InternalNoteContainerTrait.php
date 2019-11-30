<?php /** @noinspection PhpUnused */

/** @noinspection PhpUndefinedMethodInspection */

namespace Zakjakub\OswisCoreBundle\Traits\Entity;

use DateTime;

trait InternalNoteContainerTrait
{
    final public function setInternalNote(?string $note): void
    {
        if ($this->getInternalNote() !== $note) {
            $newRevision = clone $this->getRevision();
            $newRevision->setInternalNote($note);
            $this->addRevision($newRevision);
        }
    }

    final public function getInternalNote(?DateTime $dateTime = null): ?string
    {
        return $this->getRevisionByDate($dateTime)->getInternalNote();
    }
}
