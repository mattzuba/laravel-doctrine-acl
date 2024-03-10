<?php

namespace LaravelDoctrine\ACL\Mappings\Builders;

use Doctrine\ORM\Mapping\Builder\AssociationBuilder;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Illuminate\Contracts\Config\Repository;
use LaravelDoctrine\ACL\Mappings\ConfigAnnotation;
use ReflectionProperty;

class ManyToOneBuilder implements Builder
{
    public function __construct(protected Repository $config) {}

    public function build(ClassMetadata $metadata, ReflectionProperty $property, ConfigAnnotation $annotation): void
    {
        $builder = new AssociationBuilder(
            new ClassMetadataBuilder($metadata),
            [
                'fieldName'    => $property->getName(),
                'targetEntity' => $annotation->getTargetEntity($this->config),
            ],
            ClassMetadataInfo::MANY_TO_ONE
        );

        if (isset($annotation->inversedBy) && $annotation->inversedBy) {
            $builder->inversedBy($annotation->inversedBy);
        }

        $builder->build();
    }
}
