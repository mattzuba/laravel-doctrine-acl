<?php

namespace LaravelDoctrine\ACL;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Str;
use LaravelDoctrine\ORM\Configuration\Manager as ConfigurationManager;
use LaravelDoctrine\ORM\Exceptions\DriverNotFound;

abstract class Manager extends ConfigurationManager
{
    /**
     * @throws DriverNotFound
     * @throws BindingResolutionException
     */
    protected function createDriver($driver, array $settings = [], $resolve = true): mixed
    {
        $class = $this->getNamespace() . '\\' . Str::studly($driver) . $this->getClassSuffix();

        // We'll check to see if a creator method exists for the given driver. If not we
        // will check for a custom driver creator, which allows developers to create
        // drivers using their own customized driver creator Closure to create it.
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        }

        if (class_exists($class)) {
            return $this->container->make($class);
        }

        throw new DriverNotFound("Driver [$driver] not supported.");
    }
}
