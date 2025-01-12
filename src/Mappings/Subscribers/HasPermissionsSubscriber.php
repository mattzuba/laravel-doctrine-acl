<?php

namespace LaravelDoctrine\ACL\Mappings\Subscribers;

use Doctrine\ORM\Mapping\ClassMetadata;
use LaravelDoctrine\ACL\Contracts\HasPermissions as HasPermissionsContract;
use LaravelDoctrine\ACL\Mappings\Builders\JsonArrayBuilder;
use LaravelDoctrine\ACL\Mappings\Builders\ManyToManyBuilder;
use LaravelDoctrine\ACL\Mappings\ConfigAnnotation;
use LaravelDoctrine\ACL\Mappings\HasPermissions;

class HasPermissionsSubscriber extends MappedEventSubscriber
{
    protected function shouldBeMapped(ClassMetadata $metadata): bool
    {
        return $this->getInstance($metadata) instanceof HasPermissionsContract;
    }

    public function getAnnotationClass(): string
    {
        return HasPermissions::class;
    }

    protected function getBuilder(ConfigAnnotation $annotation): string
    {
        // If there's a target entity, create pivot table
        if ($annotation->getTargetEntity($this->config)) {
            return ManyToManyBuilder::class;
        }

        // Else save the permissions inside the table as json
        return JsonArrayBuilder::class;
    }
}
