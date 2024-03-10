<?php

namespace LaravelDoctrine\ACL\Mappings\Subscribers;

use Doctrine\ORM\Mapping\ClassMetadata;
use LaravelDoctrine\ACL\Contracts\BelongsToOrganisation as BelongsToOrganisationContract;
use LaravelDoctrine\ACL\Mappings\BelongsToOrganisation;
use LaravelDoctrine\ACL\Mappings\Builders\ManyToOneBuilder;
use LaravelDoctrine\ACL\Mappings\ConfigAnnotation;

class BelongsToOrganisationSubscriber extends MappedEventSubscriber
{
    protected function shouldBeMapped(ClassMetadata $metadata): bool
    {
        return $this->getInstance($metadata) instanceof BelongsToOrganisationContract;
    }

    public function getAnnotationClass(): string
    {
        return BelongsToOrganisation::class;
    }

    protected function getBuilder(ConfigAnnotation $annotation): string
    {
        return ManyToOneBuilder::class;
    }
}
