<?php

/**
 * Created by IntelliJ IDEA.
 * User: mduncan
 * Date: 10/16/15
 * Time: 10:29 AM
 */
namespace LaravelDoctrine\ACL\Concerns;

use LaravelDoctrine\ACL\Contracts\BelongsToOrganisation as BelongsToOrganisationContract;
use LaravelDoctrine\ACL\Contracts\BelongsToOrganisations as BelongsToOrganisationsContract;
use LaravelDoctrine\ACL\Contracts\Organisation as OrganisationContract;

trait BelongsToOrganisation
{
    public function belongsToOrganisation(OrganisationContract|array|string $org, bool $requireAll = false): bool
    {
        if (is_array($org)) {
            foreach ($org as $o) {
                $hasOrganisation = $this->belongsToOrganisation($o);

                if ($hasOrganisation && !$requireAll) {
                    return true;
                }

                if (!$hasOrganisation && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        }

        if ($this instanceof BelongsToOrganisationContract) {
            if (!is_null($this->getOrganisation()) && $this->getOrganisationName($org) === $this->getOrganisation()->getName()) {
                return true;
            }
        }

        if ($this instanceof BelongsToOrganisationsContract) {
            foreach ($this->getOrganisations() as $o) {
                if ($this->getOrganisationName($org) === $o->getName()) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function getOrganisationName(string|OrganisationContract $org): string
    {
        return $org instanceof OrganisationContract ? $org->getName() : $org;
    }
}
