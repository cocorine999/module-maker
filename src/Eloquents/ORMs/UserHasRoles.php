<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs;

trait UserHasRoles
{
    use HasProfiles, HasRoles {
        HasRoles::roles insteadof HasProfiles;
        HasProfiles::roles as rolesThroughProfiles;
    }
    
    /* public function roles()///: \Illuminate\Database\Eloquent\Collection
    {
        ///dd($this->roles());s
        // Merge the roles from both sources
        ///return $this->roles->concat($this->rolesThroughProfiles);
        return new \Illuminate\Support\Collection($this->roles->merge($this->rolesThroughProfiles)->unique());
    } */

    /* public function roles()
    {
        return $this->roles();
        ///return $this->mergeRoles( new Collection($this->rolesFromBelongsToMany), new Collection($this->rolesFromHasManyThrough));
    } */

    /* private function mergeRoles(Collection $belongsToManyRoles, Collection $hasManyThroughRoles)
    {
        return $belongsToManyRoles->concat($hasManyThroughRoles);
    } */

}
