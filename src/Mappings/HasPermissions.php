<?php

namespace LaravelDoctrine\ACL\Mappings;

use Attribute;
use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;
use Doctrine\ORM\Mapping\MappingAttribute;
use Illuminate\Contracts\Config\Repository;

/**
 * @Annotation
 * @Target("PROPERTY")
 * @NamedArgumentConstructor
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class HasPermissions implements MappingAttribute, ConfigAnnotation
{
    /**
     * @param class-string|null $targetEntity
     * @param string[]|null     $cascade
     * @psalm-param 'LAZY'|'EAGER'|'EXTRA_LAZY' $fetch
     */
    public function __construct(
        public ?string $targetEntity = null,
        public ?string $mappedBy = null,
        public ?string $inversedBy = null,
        public ?array $cascade = null,
        public string $fetch = 'LAZY',
        public bool $orphanRemoval = false,
        public ?string $indexBy = null
    ) {}

    public function getTargetEntity(Repository $config): ?string
    {
        // Config driver has no target entity
        if ($config->get('acl.permissions.driver', 'config') === 'config') {
            return false;
        }

        return $this->targetEntity ?: $config->get('acl.permissions.entity', 'Permission');
    }
}
