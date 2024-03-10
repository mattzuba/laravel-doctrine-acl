<?php

namespace LaravelDoctrine\ACL\Permissions;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use LaravelDoctrine\ACL\Manager;

/**
 * @method Collection getAllPermissions()
 */
class PermissionManager extends Manager
{
    public function getPermissionsWithDotNotation(): array
    {
        $permissions = $this->driver()->getAllPermissions();

        $list = $this->convertToDotArray(
            $permissions->toArray()
        );

        return Arr::flatten($list);
    }

    protected function convertToDotArray(array|string $permissions, string $prepend = ''): array
    {
        $list = [];
        if (is_array($permissions)) {
            foreach ($permissions as $key => $permission) {
                $list[] = $this->convertToDotArray($permission, (!is_numeric($key)) ? $prepend . $key . '.' : $prepend);
            }
        } else {
            $list[] = $prepend . $permissions;
        }

        return $list;
    }

    /**
     * @throws BindingResolutionException
     */
    public function getDefaultDriver(): string
    {
        return $this->container->make('config')->get('acl.permissions.driver', 'config');
    }

    public function getNamespace(): string
    {
        return __NAMESPACE__;
    }

    public function getClassSuffix(): string
    {
        return 'PermissionDriver';
    }

    public function useDefaultPermissionEntity(): bool
    {
        if (!$this->needsDoctrine()) {
            return false;
        }

        $entityFqn = $this->container->make('config')->get('acl.permissions.entity', '');
        $entityFqn = ltrim($entityFqn, "\\");

        return $entityFqn === Permission::class;
    }

    /**
     * @throws BindingResolutionException
     */
    public function needsDoctrine(): bool
    {
        return $this->getDefaultDriver() === 'doctrine';
    }
}
