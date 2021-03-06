<?php

namespace OswisOrg\OswisCoreBundle\Entity\TwigTemplate;

use OswisOrg\OswisCoreBundle\Interfaces\Common\NameableInterface;
use OswisOrg\OswisCoreBundle\Interfaces\Common\TextValueInterface;
use OswisOrg\OswisCoreBundle\Traits\Common\NameableTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\TextValueTrait;

/**
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="OswisOrg\OswisCoreBundle\Repository\TwigTemplateRepository")
 * @Doctrine\ORM\Mapping\Table(name="core_twig_template")
 * @ApiPlatform\Core\Annotation\ApiResource(
 *   attributes={
 *     "filters"={"search"},
 *     "security"="is_granted('ROLE_ADMIN')"
 *   },
 *   collectionOperations={
 *     "get"={
 *       "security"="is_granted('ROLE_ADMIN')",
 *       "normalization_context"={"groups"={"entities_get", "twig_templates_get"}, "enable_max_depth"=true},
 *     },
 *     "post"={
 *       "security"="is_granted('ROLE_ADMIN')",
 *       "denormalization_context"={"groups"={"entities_post", "twig_templates_post"}, "enable_max_depth"=true}
 *     }
 *   },
 *   itemOperations={
 *     "get"={
 *       "security"="is_granted('ROLE_ADMIN')",
 *       "normalization_context"={"groups"={"entity_get", "twig_template_get"}, "enable_max_depth"=true},
 *     },
 *     "put"={
 *       "security"="is_granted('ROLE_ADMIN')",
 *       "denormalization_context"={"groups"={"entity_put", "twig_template_put"}, "enable_max_depth"=true}
 *     }
 *   }
 * )
 * @OswisOrg\OswisCoreBundle\Filter\SearchAnnotation({
 *     "id",
 *     "slug",
 *     "type",
 *     "name"
 * })
 * @author Jakub Zak <mail@jakubzak.eu>
 * @Doctrine\ORM\Mapping\Cache(usage="NONSTRICT_READ_WRITE", region="core_twig_template")
 */
class TwigTemplate implements NameableInterface, TextValueInterface
{
    use NameableTrait;
    use TextValueTrait;

    /**
     * @Doctrine\ORM\Mapping\Column(type="string", nullable=true)
     */
    protected ?string $regularTemplateName = null;

    final public function isRegular(): bool
    {
        return (bool)$this->getRegularTemplateName();
    }

    final public function getRegularTemplateName(): ?string
    {
        return $this->regularTemplateName;
    }

    final public function setRegularTemplateName(?string $regularTemplateName): void
    {
        $this->regularTemplateName = $regularTemplateName;
    }

    final public function isFresh(?int $timestamp = null): bool
    {
        return $this->getUpdatedAt() && $this->getUpdatedAt()?->getTimestamp() <= ($timestamp ?? time());
    }

    final public function getTemplateName(): ?string
    {
        return $this->getRegularTemplateName() ?? $this->getSlug();
    }

}