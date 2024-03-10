<?php

namespace LaravelDoctrine\ACL\Contracts;

interface Role extends HasPermissions
{
    public function getName(): string;
}
