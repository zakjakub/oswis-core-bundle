<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisCoreBundle\Traits\AddressBook;

/**
 * Trait adds phone number field.
 */
trait PhoneTrait
{
    /**
     * Phone number.
     * @Doctrine\ORM\Mapping\Column(type="string", unique=false, length=60, nullable=true)
     * @Symfony\Component\Validator\Constraints\Regex(
     *     pattern="/^(\+420|\+421)? ?[1-9][0-9]{2} ?[0-9]{3} ?[0-9]{3}$/",
     *     message="Zadané číslo ({{ value }}) není platným českým nebo slovenským telefonním číslem."
     * )
     * @Symfony\Component\Validator\Constraints\Length(
     *      min = 9,
     *      max = 15
     * )
     * @ApiPlatform\Core\Annotation\ApiFilter(ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class, strategy="ipartial")
     * @ApiPlatform\Core\Annotation\ApiFilter(ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter::class)
     */
    protected ?string $phone = null;

    public function getPhone(): string
    {
        return $this->phone ?? '';
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = preg_replace('/\s+/', '', $phone);
    }
}
