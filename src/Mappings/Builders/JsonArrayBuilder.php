<?php

namespace LaravelDoctrine\ACL\Mappings\Builders;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\Builder\FieldBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
use LaravelDoctrine\ACL\Mappings\ConfigAnnotation;
use ReflectionProperty;

class JsonArrayBuilder implements Builder
{
    public function build(ClassMetadata $metadata, ReflectionProperty $property, ConfigAnnotation $annotation): void
    {
        $builder = new FieldBuilder(
            new ClassMetadataBuilder($metadata),
            [
                'fieldName' => $property->getName(),
                'type'      => Types::JSON
            ]
        );

        $builder->build();
    }
}
