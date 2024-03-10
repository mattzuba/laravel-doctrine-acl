<?php

namespace LaravelDoctrine\ACL\Contracts;

use Doctrine\Common\Collections\Collection;
use LaravelDoctrine\ACL\Contracts\Permission as PermissionContract;

interface HasPermissions
{
    public function hasPermissionTo(PermissionContract|string|array $permission): bool;

    /**
     * @return iterable<Permission>
     */
    public function getPermissions(): iterable;
}
