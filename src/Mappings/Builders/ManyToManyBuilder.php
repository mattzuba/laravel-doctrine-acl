<?php

namespace LaravelDoctrine\ACL\Mappings\Builders;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\Builder\ManyToManyAssociationBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Illuminate\Contracts\Config\Repository;
use LaravelDoctrine\ACL\Mappings\ConfigAnnotation;
use ReflectionProperty;

class ManyToManyBuilder implements Builder
{
    public function __construct(protected Repository $config) {}

    public function build(ClassMetadata $metadata, ReflectionProperty $property, ConfigAnnotation $annotation): void
    {
        $builder = new ManyToManyAssociationBuilder(
            new ClassMetadataBuilder($metadata),
            [
                'fieldName'    => $property->getName(),
                'targetEntity' => $annotation->getTargetEntity($this->config),
            ],
            ClassMetadataInfo::MANY_TO_MANY
        );

        if (isset($annotation->inversedBy) && $annotation->inversedBy) {
            $builder->inversedBy($annotation->inversedBy);
        }

        if (isset($annotation->mappedBy) && $annotation->mappedBy) {
            $builder->mappedBy($annotation->mappedBy);
        }

        $builder->build();
    }
}
