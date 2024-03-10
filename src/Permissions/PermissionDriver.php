<?php

namespace LaravelDoctrine\ACL\Permissions;

use Illuminate\Support\Collection;

interface PermissionDriver
{
    public function getAllPermissions(): Collection;
}
