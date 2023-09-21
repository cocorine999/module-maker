<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\Eloquents\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * **`Class StatutScope`**
 *
 * The **`StatutScope`** class is an implementation of the Eloquent scope interface.
 * It allows you to define a scope for filtering query results based on the `status` attribute.
 *
 * @package Core\Eloquents\Scopes
 */

/**
 * **Class StatutScope**: The StatutScope class represents a model scope for filtering by the "status" attribute.
 *
 * The **`StatutScope`** class is an implementation of the Eloquent Scope interface.
 * It is used to apply a filter to queries on a specific Eloquent model that have a "status" attribute. The scope restricts the result set to only include records with the specified "status" value.
 *
 * Usage:
 * To use the `StatutScope`, you need to apply it to the Eloquent model's query builder. You can do this by calling the `addGlobalScope` method on the model class.
 *
 * ```php
 * use Core\Eloquents\Scopes\StatutScope;
 * use Illuminate\Database\Eloquent\Model;
 *
 * class ModelContract extends Model
 * {
 *     protected static function boot()
 *     {
 *         parent::boot();
 *
 *         // Apply the StatutScope as a global scope with the default status value of true
 *         static::addGlobalScope(new StatutScope(true));
 *     }
 * }
 * ```
 *
 * ```
 * use Core\Eloquents\Scopes\StatutScope;
 * use Core\Eloquents\Models\Role;
 *
 * // Apply the scope to the query builder
 * Role::addGlobalScope(new StatutScope());
 *
 * // Retrieve records with `status` value of true
 * $records = Role::all(); // Only records with "status" set to true will be retrieved
 * ```
 *
 * The StatutScope will add a condition to the query builder, filtering records based on the `status` column with the provided default value.
 *
 * `Note:` The `status` column must be present in the table associated with the model for the scope to work correctly.
 *
 *
 * @package Core\Eloquents\Scopes
 */
class StatutScope implements Scope
{

    /**
     * The value used for filtering the 'status' attribute.
     *
     * @var bool
     */
    protected bool $status;

    /**
     * Create a new StatutScope instance.
     *
     * @param bool $value The value to use for filtering the 'status' attribute. Default is true.
     */
    public function __construct(bool $value = true)
    {
        $this->status = $value;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * This method adds a where clause to the query builder to filter the results based on the 'status' attribute.
     *
     * @param Builder $builder The Eloquent query builder.
     * @param Model   $model   The Eloquent model being queried.
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('status', $this->status);
    }
}
