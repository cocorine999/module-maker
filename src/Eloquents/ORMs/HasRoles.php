<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs;

use App\Models\Role;
use Illuminate\Support\Str;


/**
 * Trait ***`HasRoles`***
 *
 * The `HasRoles` trait provides functionality related to assigning and managing roles for a model.
 *
 * Usage:
 * - This trait should be used in models that have a "roles" association.
 *
 * Methods:
 * - `roles()`: Define a many-to-many relationship with the Role model.
 * - `hasRole($role, $filter = 'slug')`: Check if the model has a specific role.
 * - `assignRole($role)`: Assign a role to the model.
 * - `revokeRole($role)`: Revoke a role from the model.
 * - `getRoles()`: Get all roles associated with the model.
 * - `assignAccess($roleIds, $data = [])`: Grant access to certain roles for the model.
 * - `revokeAccess($roles, $data = [], $filter = 'id')`: Revoke access to certain roles for the model.
 * - `getRolesBy($roles, $filter = 'slug')`: Retrieve roles based on the specified filter and role identifiers.
 * - `scopeWhereRoles($query, $roles, $filter = 'id')`: Scope to filter models based on the roles they have.
 *
 * Example Usage:
 * ```
 * use Illuminate\Database\Eloquent\Model;
 * use LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs\HasRoles;
 *
 * class User extends Model
 * {
 *     use HasRoles;
 *
 *     // Model implementation
 * }
 *
 * // Assigning and checking roles
 * $user = User::find(1);
 * $user->assignRole('admin');
 * $hasAdminRole = $user->hasRole('admin');
 *
 * // Revoking a role
 * $user->revokeRole('admin');
 *
 * // Querying models with specific roles
 * $admins = User::whereRoles('admin')->get();
 * ```
 *
 * @package LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs
 */
trait HasRoles
{
    /**
     * Define a many-to-many relationship with the Role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        $intermediateTable = convert_to_snake_case(class_basename(__CLASS__)) . '_has_roles';
        $intermediateModel = class_basename(__CLASS__) . 'HasRole';

        $relationship = $this->belongsToMany(Role::class, $intermediateTable, convertToSnakeCase(class_basename(__CLASS__)) . '_id', 'role_id')
            ->withPivot(['status', 'deleted_at', 'can_be_detach'])
            ->wherePivot('status', true)
            ->wherePivot('deleted_at', null);

        if (class_exists("App\\Models\\$intermediateModel")) {
            $relationship->using("App\\Models\\$intermediateModel");
        }

        return $relationship;
    }

    /**
     * Check if the model has the specified role.
     *
     * @param  \App\Models\Role|string $role
     * @param  string $filter
     * @return bool
     */
    public function hasRole($role, string $filter = 'slug'): bool
    {
        if ($role instanceof Role) {
            $role = $role->$filter;
        }

        return $this->roles()->where($filter, $role)->exists();
    }

    /**
     * Assign a role to the user.
     *
     * @param string|\App\Models\Role|string|array $role
     * @return self
     */
    public function assignRole($roleIds, string $filter = 'id', array $data = []): self
    {

        if(is_string($roleIds))
        {
            if(Str::isUuid($roleIds)){
                $roleIds = [Role::where("id", $roleIds)->firstOrFail()->id];
            }
            else{
                $roleIds = [Role::where("$filter", $roleIds)->firstOrFail()->id];
            }
        }
        else if($roleIds instanceof Role)
        {
            $roleIds = [$roleIds->id];
        }

        else if(is_array($roleIds))
        {
            $roleIds = $this->checkRoleIds($roleIds, 'id', 'id');
        }

        $existingRoleIds = $this->roles()->wherePivotIn('role_id', $roleIds)->pluck('role_id')->toArray();

        $newRoleIds = array_diff($roleIds, $existingRoleIds);

        if (!empty($newRoleIds)) {
            $this->roles()->attach($newRoleIds);
        }

        return $this;
    }

    /**
     * Revoke a role from the user.
     *
     * @param string|\App\Models\Role $role
     * @return void
     */
    public function revokeRole($role): void
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }

        $this->roles()->detach($role);
    }

    /**
     * Get all roles associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoles(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->roles;
    }

    /**
     * Accorde l'accès à certaines roles pour le modèle.
     *
     * @param  \App\Models\Role|string|array  $roles
     * @param  array $data
     * @return self
     */
    public function assignAccess($roleIds, array $data = []): self
    {
        if(is_string($roleIds))
        {
            $roleIds = [$roleIds];
        }
        else if($roleIds instanceof Role)
        {
            $roleIds = [$roleIds->id];
        }

        else if(is_array($roleIds))
        {
            $roleIds = $this->checkRoleIds($roleIds, 'id', 'id');
        }

        $existingRoleIds = $this->roles()->wherePivotIn('role_id', $roleIds)->pluck('role_id')->toArray();

        $newRoleIds = array_diff($roleIds, $existingRoleIds);

        if (!empty($newRoleIds)) {
            $this->roles()->attach($newRoleIds, $data);
        }

        return $this;
    }

    /**
     * Révoque l'accès à certaines roles pour le modèle.
     *
     * @param  \App\Models\Role|string|array $roles
     * @param  array $data
     * @param  string $filter
     * @return self
     */
    public function revokeAccess($roles, array $data = [], string $filter = 'id'): self
    {
        $roleIds = $this->getRolesBy($roles, $filter)->toArray();

        foreach ($this->roles()->wherePivotIn("id_role", $roleIds)->get() as $key => $role) {
            $role->pivot->delete();
        }

        return $this;
    }

    public function checkRoleIds(array $roleIds, string $key = 'slug', $filter = 'id')
    {
        return collect($roleIds)->flatten()->map(function ($role) use ($key, $filter) {
            return $role instanceof Role ? $role->{$filter} : Role::where("{$key}", $role)->value($filter);
        })->filter();
    }

    /**
     * Obtient les roles correspondant au filtre et aux roles spécifiées.
     *
     * @param  string $filter
     * @param  \App\Models\Role|string|array $roles
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRolesBy($roles, string $filter = 'slug')
    {
        return collect($roles)->flatten()->map(function ($role) use ($filter) {
            return $role instanceof Role ? $role->{$filter} : Role::where("{$filter}", $role)->value($filter);
        })->filter();
    }

    /**
     * Scope the query to only include models with the given role(s).
     *
     * @param  \Illuminate\Contracts\Database\Eloquent\Builder $query
     * @param  \App\Models\Role|string|array             $roles
     * @return \Illuminate\Contracts\Database\Eloquent\Builder
     */
    public function scopeWhereRoles(\Illuminate\Contracts\Database\Eloquent\Builder $query, $roles, string $filter = 'id'): \Illuminate\Contracts\Database\Eloquent\Builder
    {
        $roleIds = $this->getRolesBy(roles: $roles, filter: $filter)->toArray();
    
        return $query->whereHas('roles', function ($query) use ($roleIds, $filter) {
            $query->whereIn("{$filter}", (array) $roleIds);
        });
    }

}