<?php

namespace LaravelDoctrine\ACL\Mappings;

use Attribute;
use Doctrine\Common\Annotations\Annotation;
use Doctrine\ORM\Mapping\MappingAttribute;
use Illuminate\Contracts\Config\Repository;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class BelongsToOrganisations implements MappingAttribute, ConfigAnnotation
{
    /**
     * @param class-string|null $targetEntity
     * @param string[]|null     $cascade
     * @psalm-param 'LAZY'|'EAGER'|'EXTRA_LAZY' $fetch
     */
    public function __construct(
        public ?string $targetEntity = null,
        public ?string $mappedBy = null,
        public ?string $inversedBy = 'users',
        public ?array $cascade = null,
        public string $fetch = 'LAZY',
        public bool $orphanRemoval = false,
        public ?string $indexBy = null
    ) {}

    public function getTargetEntity(Repository $config): ?string
    {
        return $this->targetEntity ?: $config->get('acl.organisations.entity', 'Organisation');
    }
}
