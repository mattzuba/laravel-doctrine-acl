<?php

namespace LaravelDoctrine\ACL\Contracts;

interface BelongsToOrganisation
{
    public function getOrganisation(): ?Organisation;
}
