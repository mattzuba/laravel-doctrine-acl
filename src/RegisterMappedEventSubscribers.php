<?php

namespace LaravelDoctrine\ACL;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\AttributeReader;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Container\Container;
use LaravelDoctrine\ACL\Mappings\Driver\AttributeAnnotationReader;
use LaravelDoctrine\ACL\Mappings\Subscribers\BelongsToOrganisationsSubscriber;
use LaravelDoctrine\ACL\Mappings\Subscribers\BelongsToOrganisationSubscriber;
use LaravelDoctrine\ACL\Mappings\Subscribers\HasPermissionsSubscriber;
use LaravelDoctrine\ACL\Mappings\Subscribers\HasRolesSubscriber;
use LaravelDoctrine\ORM\DoctrineExtender;

class RegisterMappedEventSubscribers implements DoctrineExtender
{
    public function __construct(protected Container $app) {}

    /**
     * @var array
     */
    protected array $subscribers = [
        BelongsToOrganisationsSubscriber::class,
        BelongsToOrganisationSubscriber::class,
        HasRolesSubscriber::class,
        HasPermissionsSubscriber::class,
    ];

    public function extend(Configuration $configuration, Connection $connection, EventManager $eventManager): void
    {
        $reader = new AttributeAnnotationReader(new AttributeReader, new AnnotationReader);
        foreach ($this->subscribers as $subscriber) {
            $eventManager->addEventSubscriber(new $subscriber($reader, $this->app->make(Config::class)));
        }
    }
}
