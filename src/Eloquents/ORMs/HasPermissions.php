<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs;

use App\Models\Permission;


/**
 * Trait ***`HasPermissions`***
 *
 * The `HasPermissions` trait provides functionality related to assigning and managing permissions for a model.
 *
 * Usage:
 * - This trait should be used in models that have a "permissions" association.
 *
 * Methods:
 * - `permissions()`: Define a many-to-many relationship with the Permission model.
 * - `hasPermission($permission, $filter = 'slug')`: Check if the model has a specific permission.
 * - `assignPermission($permission)`: Assign a permission to the model.
 * - `revokePermission($permission)`: Revoke a permission from the model.
 * - `getPermissions()`: Get all permissions associated with the model.
 * - `assignAccess($permissionIds, $data = [])`: Grant access to certain permissions for the model.
 * - `revokeAccess($permissions, $data = [], $filter = 'id')`: Revoke access to certain permissions for the model.
 * - `getPermissionsBy($permissions, $filter = 'slug')`: Retrieve permissions based on the specified filter and permission identifiers.
 * - `scopeWherePermissions($query, $permissions, $filter = 'id')`: Scope to filter models based on the permissions they have.
 *
 * Example Usage:
 * ```
 * use Illuminate\Database\Eloquent\Model;
 * use LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs\HasPermissions;
 *
 * class User extends Model
 * {
 *     use HasPermissions;
 *
 *     // Model implementation
 * }
 *
 * // Assigning and checking permissions
 * $user = User::find(1);
 * $user->assignPermission('admin');
 * $hasAdminPermission = $user->hasPermission('admin');
 *
 * // Revoking a permission
 * $user->revokePermission('admin');
 *
 * // Querying models with specific permissions
 * $admins = User::wherePermissions('admin')->get();
 * ```
 *
 * @package LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs
 */
trait HasPermissions
{
    /**
     * Define a many-to-many relationship with the Permission model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        $intermediateTable = convert_to_snake_case(class_basename(__CLASS__)) . '_has_permissions';
        $intermediateModel = class_basename(__CLASS__) . 'HasPermission';

        $relationship = $this->belongsToMany(Permission::class, $intermediateTable, convertToSnakeCase(class_basename(__CLASS__)) . '_id', 'permission_id')
            ->withPivot(['status', 'deleted_at', 'can_be_detach'])
            ->wherePivot('status', true)
            ->wherePivot('deleted_at', null);

        if (class_exists("App\\Models\\$intermediateModel")) {
            $relationship->using("App\\Models\\$intermediateModel");
        }

        return $relationship;
    }

    /**
     * Check if the model has the specified permission.
     *
     * @param  \App\Models\Permission|string $permission
     * @param  string $filter
     * @return bool
     */
    public function hasPermission($permission, string $filter = 'slug'): bool
    {
        if ($permission instanceof Permission) {
            $permission = $permission->$filter;
        }

        return $this->permissions()->where($filter, $permission)->exists();
    }

    /**
     * Assign a permission to the user.
     *
     * @param string|\App\Models\Permission $permission
     * @return void
     */
    public function assignPermission($permission): void
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->firstOrFail();
        }

        $this->permissions()->syncWithoutDetaching($permission);
    }

    /**
     * Revoke a permission from the user.
     *
     * @param string|\App\Models\Permission $permission
     * @return void
     */
    public function revokePermission($permission): void
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->firstOrFail();
        }

        $this->permissions()->detach($permission);
    }

    /**
     * Get all permissions associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPermissions(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->permissions;
    }

    /**
     * Accorde l'accès à certaines permissions pour le modèle.
     *
     * @param  \App\Models\Permission|string|array  $permissions
     * @param  array $data
     * @return self
     */
    public function assignAccess($permissionIds, array $data = []): self
    {
        if(is_string($permissionIds))
        {
            $permissionIds = [$permissionIds];
        }
        else if(!is_array($permissionIds) && $permissionIds instanceof Permission)
        {
            $permissionIds = [$permissionIds->id];
        }

        $existingPermissionIds = $this->permissions()->wherePivotIn('id_permission', $permissionIds)->pluck('id_permission')->toArray();

        $newPermissionIds = array_diff($permissionIds, $existingPermissionIds);

        if (!empty($newPermissionIds)) {
            $this->permissions()->attach($newPermissionIds, $data);
        }

        return $this;
    }

    /**
     * Révoque l'accès à certaines permissions pour le modèle.
     *
     * @param  \App\Models\Permission|string|array $permissions
     * @param  array $data
     * @param  string $filter
     * @return self
     */
    public function revokeAccess($permissions, array $data = [], string $filter = 'id'): self
    {
        $permissionIds = $this->getPermissionsBy($permissions, $filter)->toArray();

        foreach ($this->permissions()->wherePivotIn("id_permission", $permissionIds)->get() as $key => $permission) {
            $permission->pivot->delete();
        }

        return $this;
    }

    /**
     * Obtient les permissions correspondant au filtre et aux permissions spécifiées.
     *
     * @param  string $filter
     * @param  \App\Models\Permission|string|array $permissions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPermissionsBy($permissions, string $filter = 'slug')
    {
        return collect($permissions)->flatten()->map(function ($permission) use ($filter) {
            return $permission instanceof Permission ? $permission->{$filter} : Permission::where("{$filter}", $permission)->value($filter);
        })->filter();
    }

    /**
     * Scope the query to only include models with the given permission(s).
     *
     * @param  \Illuminate\Contracts\Database\Eloquent\Builder $query
     * @param  \App\Models\Permission|string|array             $permissions
     * @return \Illuminate\Contracts\Database\Eloquent\Builder
     */
    public function scopeWherePermissions(\Illuminate\Contracts\Database\Eloquent\Builder $query, $permissions, string $filter = 'id'): \Illuminate\Contracts\Database\Eloquent\Builder
    {
        $permissionIds = $this->getPermissionsBy(permissions: $permissions, filter: $filter)->toArray();
    
        return $query->whereHas('permissions', function ($query) use ($permissionIds, $filter) {
            $query->whereIn("{$filter}", (array) $permissionIds);
        });
    }

}