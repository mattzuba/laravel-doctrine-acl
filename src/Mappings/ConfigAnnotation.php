<?php

namespace LaravelDoctrine\ACL\Mappings;

use Illuminate\Contracts\Config\Repository;

interface ConfigAnnotation
{
    public function getTargetEntity(Repository $config): ?string;
}
