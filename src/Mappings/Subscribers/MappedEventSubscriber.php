<?php

namespace LaravelDoctrine\ACL\Mappings\Subscribers;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Contracts\Config\Repository;
use LaravelDoctrine\ACL\Mappings\ConfigAnnotation;
use ReflectionClass;
use ReflectionProperty;

abstract class MappedEventSubscriber implements EventSubscriber
{
    public function __construct(protected Reader $reader, protected Repository $config) {}

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $metadata = $eventArgs->getClassMetadata();

        if ($this->isInstantiable($metadata) && $this->shouldBeMapped($metadata)) {
            foreach ($metadata->getReflectionClass()->getProperties() as $property) {
                if ($annotation = $this->findMapping($property)) {
                    $builder = $this->getBuilder($annotation);
                    $builder = new $builder($this->config);
                    $builder->build($metadata, $property, $annotation);
                }
            }
        }
    }

    abstract protected function shouldBeMapped(ClassMetadata $metadata): bool;

    abstract public function getAnnotationClass(): string;

    protected function findMapping(ReflectionProperty $property)
    {
        return $this->reader->getPropertyAnnotation($property, $this->getAnnotationClass());
    }

    /**
     * @throws \ReflectionException
     */
    protected function getInstance(ClassMetadata $metadata): object
    {
        return (new ReflectionClass($metadata->getName()))->newInstanceWithoutConstructor();
    }

    abstract protected function getBuilder(ConfigAnnotation $annotation): string;

    protected function isInstantiable(ClassMetadata $metadata): bool
    {
        if ($metadata->isMappedSuperclass) {
            return false;
        }

        if (!$metadata->getReflectionClass() || $metadata->getReflectionClass()->isAbstract()) {
            return false;
        }

        return true;
    }
}
