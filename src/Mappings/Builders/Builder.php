<?php

namespace LaravelDoctrine\ACL\Mappings\Builders;

use Doctrine\ORM\Mapping\ClassMetadata;
use LaravelDoctrine\ACL\Mappings\ConfigAnnotation;
use ReflectionProperty;

interface Builder
{
    public function build(ClassMetadata $metadata, ReflectionProperty $property, ConfigAnnotation $annotation): void;
}
