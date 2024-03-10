<?php

namespace LaravelDoctrine\ACL\Permissions;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Collection;

class ConfigPermissionDriver implements PermissionDriver
{
    public function __construct(protected Repository $repository) {}

    /**
     * @return Collection
     */
    public function getAllPermissions(): Collection
    {
        return new Collection(
            $this->repository->get('acl.permissions.list', [])
        );
    }
}
