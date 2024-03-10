<?php

namespace LaravelDoctrine\ACL\Concerns;

use Doctrine\Common\Collections\Collection;
use LaravelDoctrine\ACL\Contracts\Role;

trait HasRoles
{
    public function hasRole(Role|array $role, bool $requireAll = false): bool
    {
        if (is_array($role)) {
            foreach ($role as $r) {
                $hasRole = $this->hasRole($r);

                if ($hasRole && !$requireAll) {
                    return true;
                }

                if (!$hasRole && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        }

        foreach ($this->getRoles() as $ownedRole) {
            if ($ownedRole === $role) {
                return true;
            }
        }

        return false;
    }

    public function hasRoleByName(array|string $name, bool $requireAll = false): bool
    {
        if (is_array($name)) {
            foreach ($name as $n) {
                $hasRole = $this->hasRoleByName($n);

                if ($hasRole && !$requireAll) {
                    return true;
                }

                if (!$hasRole && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        }

        foreach ($this->getRoles() as $ownedRole) {
            if ($ownedRole->getName() === $name) {
                return true;
            }
        }

        return false;
    }
}
