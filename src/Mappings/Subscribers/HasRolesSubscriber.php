<?php

namespace LaravelDoctrine\ACL\Mappings\Subscribers;

use Doctrine\ORM\Mapping\ClassMetadata;
use LaravelDoctrine\ACL\Contracts\HasRoles as HasRolesContract;
use LaravelDoctrine\ACL\Mappings\Builders\ManyToManyBuilder;
use LaravelDoctrine\ACL\Mappings\ConfigAnnotation;
use LaravelDoctrine\ACL\Mappings\HasRoles;

class HasRolesSubscriber extends MappedEventSubscriber
{
    protected function shouldBeMapped(ClassMetadata $metadata): bool
    {
        return $this->getInstance($metadata) instanceof HasRolesContract;
    }

    public function getAnnotationClass(): string
    {
        return HasRoles::class;
    }

    protected function getBuilder(ConfigAnnotation $annotation): string
    {
        return ManyToManyBuilder::class;
    }
}
