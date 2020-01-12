<?php
/**
 * @noinspection PhpUnused
 */

namespace Zakjakub\OswisCoreBundle\Entity\AbstractClass;

use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\HttpFoundation\File\File;
use Zakjakub\OswisCoreBundle\Traits\Entity\BasicEntityTrait;

/**
 * Abstract image file class for use in uploads and forms.
 *
 * @author       Jakub Zak <mail@jakubzak.eu>
 * @noinspection ClassNameCollisionInspection
 */
abstract class AbstractImage
{
    use BasicEntityTrait;

    /**
     * @var File|null
     * @Symfony\Component\Validator\Constraints\NotNull()
     * @Vich\UploaderBundle\Mapping\Annotation\UploadableField(
     *     mapping="abstract_image",
     *     fileNameProperty="contentUrl",
     *     dimensions={"contentDimensionsWidth", "contentDimensionsHeight"},
     *     mimeType="contentMimeType"
     * )
     */
    public ?File $file = null;

    /**
     * @var string|null
     * @Doctrine\ORM\Mapping\Column(nullable=true)
     * @ApiProperty(iri="http://schema.org/contentUrl")
     */
    public ?string $contentUrl = null;

    /**
     * @var int|null
     * @Doctrine\ORM\Mapping\Column(nullable=true)
     */
    public ?int $contentSize = null;

    /**
     * @var string|null
     * @Doctrine\ORM\Mapping\Column(nullable=true)
     */
    public ?string $contentMimeType = null;

    /**
     * @var string|null
     * @Doctrine\ORM\Mapping\Column(nullable=true)
     */
    public ?string $contentOriginalName = null;

    /**
     * @var int|null
     * @Doctrine\ORM\Mapping\Column(nullable=true)
     */
    public ?int $contentDimensionsWidth = null;

    /**
     * @var int|null
     * @Doctrine\ORM\Mapping\Column(nullable=true)
     */
    public ?int $contentDimensionsHeight = null;

    /** @noinspection MethodShouldBeFinalInspection */
    public function __toString(): string
    {
        return $this->contentUrl ?? '';
    }
}
