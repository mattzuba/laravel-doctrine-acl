<?php

namespace LaravelDoctrine\ACL\Contracts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

interface BelongsToOrganisations
{
    /**
     * @return iterable<Organisation>
     */
    public function getOrganisations(): iterable;
}
