<?php

namespace LaravelDoctrine\ACL\Mappings\Subscribers;

use Doctrine\ORM\Mapping\ClassMetadata;
use LaravelDoctrine\ACL\Contracts\BelongsToOrganisations as BelongsToOrganisationsContract;
use LaravelDoctrine\ACL\Mappings\BelongsToOrganisations;
use LaravelDoctrine\ACL\Mappings\Builders\ManyToManyBuilder;
use LaravelDoctrine\ACL\Mappings\ConfigAnnotation;

class BelongsToOrganisationsSubscriber extends MappedEventSubscriber
{
    /**
     * @throws \ReflectionException
     */
    protected function shouldBeMapped(ClassMetadata $metadata): bool
    {
        return $this->getInstance($metadata) instanceof BelongsToOrganisationsContract;
    }

    public function getAnnotationClass(): string
    {
        return BelongsToOrganisations::class;
    }

    protected function getBuilder(ConfigAnnotation $annotation): string
    {
        return ManyToManyBuilder::class;
    }
}
