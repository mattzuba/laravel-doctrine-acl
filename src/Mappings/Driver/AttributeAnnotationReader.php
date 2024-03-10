<?php

namespace LaravelDoctrine\ACL\Mappings\Driver;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Mapping\Driver\AttributeReader;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class AttributeAnnotationReader implements Reader
{
    public function __construct(private AttributeReader $attributeReader, private AnnotationReader $annotationReader) {}

    public function getClassAnnotations(ReflectionClass $class)
    {
        if (!empty($annotations = $this->attributeReader->getClassAttributes($class))) {
            return $annotations;
        }

        return $this->annotationReader->getClassAnnotations($class);
    }

    public function getClassAnnotation(ReflectionClass $class, $annotationName)
    {
        if (!empty($annotations = $this->attributeReader->getClassAttributes($class))) {
            return $annotations[$annotationName] ?? null;
        }

        return $this->annotationReader->getClassAnnotation($class, $annotationName);
    }

    public function getMethodAnnotations(ReflectionMethod $method)
    {
        if (!empty($annotations = $this->attributeReader->getMethodAttributes($method))) {
            return $annotations;
        }

        return $this->annotationReader->getMethodAnnotations($method);
    }

    public function getMethodAnnotation(ReflectionMethod $method, $annotationName)
    {
        if (!empty($annotations = $this->attributeReader->getMethodAttributes($method))) {
            return $annotations[$annotationName] ?? null;
        }

        return $this->annotationReader->getMethodAnnotation($method, $annotationName);
    }

    public function getPropertyAnnotations(ReflectionProperty $property)
    {
        if (!empty($annotations = $this->attributeReader->getPropertyAttributes($property))) {
            return $annotations;
        }

        return $this->annotationReader->getPropertyAnnotations($property);
    }

    public function getPropertyAnnotation(ReflectionProperty $property, $annotationName)
    {
        if (($annotation = $this->attributeReader->getPropertyAttribute($property, $annotationName)) !== null) {
            return $annotation;
        }

        return $this->annotationReader->getPropertyAnnotation($property, $annotationName);
    }
}
