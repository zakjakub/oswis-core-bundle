<?php /** @noinspection PhpUnused */

namespace Zakjakub\OswisCoreBundle\Traits\Entity;

/**
 * Trait adds description field.
 */
trait IdCardTrait
{
    /**
     * ID card type (as string).
     *
     * @var string|null
     * @Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     */
    protected ?string $idCardType = null;

    /**
     * ID card number (as string).
     *
     * @var string|null
     * @Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     */
    protected ?string $idCardNumber = null;

    /**
     * @return string
     */
    final public function getIdCardType(): ?string
    {
        return $this->idCardType;
    }

    /**
     * @param string $idCardType
     */
    final public function setIdCardType(?string $idCardType): void
    {
        $this->idCardType = $idCardType;
    }

    /**
     * @return string
     */
    final public function getIdCardNumber(): ?string
    {
        return $this->idCardNumber;
    }

    /**
     * @param string $idCardNumber
     */
    final public function setIdCardNumber(?string $idCardNumber): void
    {
        $this->idCardNumber = $idCardNumber;
    }
}
