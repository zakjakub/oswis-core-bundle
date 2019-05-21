<?php

namespace Zakjakub\OswisCoreBundle\Traits\Entity;

use InvalidArgumentException;

/**
 * Trait adds type field and some attended fiends and functions.
 */
trait TypeTrait
{

    abstract public static function getAllowedTypesDefault(): array;
    abstract public static function getAllowedTypesCustom(): array;

    final public static function getAllowedTypes(): array {
        return array_merge(self::getAllowedTypesDefault(), self::getAllowedTypesCustom());
    }

    /**
     * @param string|null $typeName
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    final public static function checkType(?string $typeName): bool
    {
        if (in_array($typeName, self::getAllowedTypes(), true)) {
            return true;
        }
        throw new InvalidArgumentException('Typ příznaku kontaktu "'.$typeName.'" v události není povolen.');
    }



    /**
     * Type of this event.
     * @var string|null $type
     * @Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     */
    private $type;

    /**
     * @return string|null
     * @throws InvalidArgumentException
     */
    final public function getType(): ?string
    {
        self::checkType($this->type);
        return $this->type;
    }

    /**
     * @param string|null $type
     *
     * @throws InvalidArgumentException
     */
    final public function setType(?string $type): void
    {
        self::checkType($type);
        $this->type = $type;
    }




}