<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Repositories\Eloquent;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * ***`BaseRepository`***
 *
 * The `BaseRepository` class serves as a foundational class for repositories in your application.
 * It provides common CRUD operations and basic query methods that can be shared among repositories.
 *
 * @package ***`LaravelCoreModule\CoreModuleMaker\Repositories\Eloquent`***
 */
class BaseRepository
{
    /**
     * The model associated with the repository.
     *
     * @var \Illuminate\Database\Eloquent\Model|null
     */
    protected ?Model $model;

    /**
     * The cache key for caching repository data.
     *
     * @var string
     */
    protected string $cache_key;

    /**
     * The number of minutes to cache the repository data.
     *
     * @var int
     */
    protected int $cache_minutes;


    /**
     * BaseRepository constructor.
     *
     * @param \Illuminate\Database\Eloquent\Model $model The model associated with the repository.
     */
    public function __construct(Model $model, ?string $cache_key = null, int $cache_minutes = 0)
    {
        $this->model = $model;

        $this->setCacheKey($cache_key);
    }


    /**
     * Set the model associated with the repository.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $model The model instance.
     * @return void
     */
    public function setModel(?Model $model): void
    {
        $this->model = $model;
    }

    /**
     * Get the model associated with the repository.
     *
     * @return \Illuminate\Database\Eloquent\Model|null The model instance.
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }

    /**
     * Get the name of the model associated with the repository.
     *
     * @return string|null The model name.
     */
    public function getModelName(): ?string
    {
        return class_basename($this->model::class);
    }

    /**
     * Set the cache key for caching repository data.
     *
     * @param string|null $cache_key The cache key. If null, a default key value will be used.
     * @return void
     */
    public function setCacheKey(?string $cache_key = null): void
    {
        $this->cache_key = $cache_key ?? 'cache_' . strtolower($this->getModelName()) . '_key';
    }

    /**
     * Get the cache key for caching repository data.
     *
     * @return string The cache key.
     */
    public function getCacheKey(): string
    {
        return $this->cache_key;
    }

    /**
     * Set the number of minutes to cache the repository data.
     *
     * @param int $cache_minutes The number of minutes.
     * @return void
     */
    public function setCacheMinutes(int $cache_minutes): void
    {
        $this->cache_minutes = $cache_minutes;
    }

    /**
     * Get the number of minutes to cache the repository data.
     *
     * @return int The number of minutes.
     */
    public function getCacheMinutes(): int
    {
        return $this->cache_minutes;
    }

    /**
     * Perform indexing of records.
     *
     * @param  array  $options  Additional options for indexing.
     * @return void
     */
    protected function _index(array $options = []): void
    {
        // Implementation logic goes here
    }

    public function onlyTrashed(array $columns = ['*'])
    {
        return $this->model->select($columns)->onlyTrashed();
    }

    /**
     * Paginate the query results.
     *
     * @param int      $perPage  The number of results to display per page.
     * @param string   $pageName The query string variable used to store the current page.
     * @param int|null $page     The current page number.
     * @return \Illuminate\Database\Eloquent\Builder The query builder instance for pagination.
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model->query()->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * Apply criteria to the query.
     *
     * @param array $criteria The criteria to apply to the query.
     * @return \Illuminate\Database\Eloquent\Builder The query builder instance with applied criteria.
     */
    public function whereCriteria(Builder $builder, string $column, string $condition, $value, $query = "where"): \Illuminate\Database\Eloquent\Builder
    {
        return $builder->{$query}($column, $condition, $value);
    }

    /**
     * Apply a range condition to the query.
     *
     * @param  string  $column  The column name to apply the range condition on.
     * @param  mixed   $start   The start value of the range.
     * @param  mixed   $end     The end value of the range.
     * @return \Illuminate\Database\Query\Builder
     */
    public function range(string $column, $start, $end): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->whereBetween($column, [$start, $end]);
    }

    /**
     * Apply multiple criteria to the query using the given conditions.
     *
     * @param array $conditions The conditions to filter the query.
     * @return \Illuminate\Database\Eloquent\Builder The query builder with the applied conditions.
     */
    public function filter(array $conditions, \Illuminate\Database\Eloquent\Builder $builder = null): Builder
    {
        $builder = $builder ?? $this->model->query();

        foreach ($conditions as $condition) {
            $builder = $this->whereCriteria($builder, $condition['column'], $condition['condition'], $condition['value'], $condition['query']);
        }

        return $builder;
    }
}
