<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 * @noinspection PhpUnused
 */

namespace OswisOrg\OswisCoreBundle\Traits\Common;

use OswisOrg\OswisCoreBundle\Entity\NonPersistent\Nameable;
use Symfony\Component\String\Slugger\AsciiSlugger;

trait NameableTrait
{
    use BasicTrait;
    use SlugTrait;
    use NameTrait;
    use DescriptionTrait;
    use NoteTrait;
    use InternalNoteTrait;

    public function setFieldsFromNameable(?Nameable $nameable = null): void
    {
        if (null !== $nameable) {
            $this->setName($nameable->name);
            $this->setDescription($nameable->description);
            $this->setShortName($nameable->shortName);
            $this->setNote($nameable->note);
            $this->setForcedSlug($nameable->forcedSlug);
            $this->setInternalNote($nameable->internalNote);
        }
    }

    public function getNameable(): Nameable
    {
        return new Nameable($this->getName(), $this->getShortName(), $this->getDescription(), $this->getNote(), $this->getForcedSlug(), $this->getInternalNote());
    }

    public function updateSlug(): string
    {
        return $this->setSlug($this->getForcedSlug() ?? $this->getAutoSlug());
    }

    public function getAutoSlug(): ?string
    {
        return (new AsciiSlugger())->slug(($this->getName() ?? $this->getShortName()))->lower()->toString();
    }
}