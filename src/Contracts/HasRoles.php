<?php

namespace LaravelDoctrine\ACL\Contracts;

use Doctrine\Common\Collections\Collection;

interface HasRoles
{
    /**
     * @return iterable<Role>
     */
    public function getRoles(): iterable;
}
