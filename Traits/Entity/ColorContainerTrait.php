<?php /** @noinspection PhpUnused */

/** @noinspection PhpUndefinedMethodInspection */

namespace Zakjakub\OswisCoreBundle\Traits\Entity;

use DateTime;

trait ColorContainerTrait
{
    final public function setColor(?string $color): void
    {
        if ($this->getColor() !== $color) {
            $newRevision = clone $this->getRevisionByDate();
            $newRevision->setColor($color);
            $this->addRevision($newRevision);
        }
    }

    final public function getColor(?DateTime $dateTime = null): ?string
    {
        return $this->getRevisionByDate($dateTime)->getColor();
    }

    final public function isForegroundWhite(?DateTime $dateTime = null): string
    {
        return $this->getRevisionByDate($dateTime)->isForegroundWhite();
    }
}
