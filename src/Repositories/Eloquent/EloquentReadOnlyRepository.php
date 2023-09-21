<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Repositories\Eloquent;

use LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException;
use LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException;
use LaravelCoreModule\CoreModuleMaker\Repositories\Contracts\ReadOnlyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;


/**
 * The ***`EloquentReadOnlyRepository`*** abstract class.
 *
 * This abstract class serves as a base class for read-only repositories that interact with an Eloquent model.
 * It implements the `ReadOnlyRepositoryInterface` and provides common read operations.
 *
 * @package ***`LaravelCoreModule\CoreModuleMaker\Repositories\Eloquent`***
 */
class EloquentReadOnlyRepository extends BaseRepository implements ReadOnlyRepositoryInterface
{

    /**
     * `EloquentReadOnlyRepository` constructor.
     *
     * Creates a new instance of the `EloquentReadOnlyRepository` class, associating it with the provided Eloquent model.
     * This constructor is called when you create a new instance of the repository, allowing you to specify the model
     * that the repository will interact with.
     *
     * @param \Illuminate\Database\Eloquent\Model $model The Eloquent model associated with the repository.
     */
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all records.
     *
     * @param  array $columns                           The columns to select.
     * @return \Illuminate\Database\Eloquent\Collection The collection of all records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException     If there is an error while retrieving the records.
     */
    public function all(array $columns = ['*']): Collection
    {
        try {
            return $this->model->select($columns)->get();
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while retrieving records.", previous: $exception);
        }
    }

    /**
     * Find a record by its ID.
     *
     * @param  Model|string $id                                     The ID of the record.
     * @param  array        $columns                                The columns to select.
     * @return Model|null                                           The found record, or null if not found.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the record with the given ID is not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException                      If there is an error while retrieving the record.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException                 If there is an error while retrieving the record.
     */
    public function find($id, array $columns = ['*']): ?Model
    {
        try {
            return $this->model->select($columns)->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            // Customize the message for ModelNotFoundException
            throw new QueryException(message: "Record not found.", previous: $exception);
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while retrieving the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while retrieving records.", previous: $exception);
        }
    }

    /**
     * Get the first record that matches the given conditions.
     *
     * @param  array<int, array> $conditions        The conditions for filtering the records.
     * @param array $columns                        The columns to select.
     * @return Model|null                           The first matching record, or null if not found.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException If there is an error while retrieving the record.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException      If there is an error while retrieving the record.
     */
    public function first(array $conditions, array $columns = ['*']): ?Model
    {
        try {
            return $this->model->select($columns)->where($conditions)->first();
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while retrieving the record.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while retrieving the record.", previous: $exception);
        }
    }

    /**
     * Check if a record exists based on the given conditions.
     *
     * @param  array<int, array> $conditions        The conditions for filtering the records.
     * @return bool                                 Whether a record exists or not.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException If there is an error while checking for record existence.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException      If there is an error while checking for record existence.
     */
    public function exists(array $conditions): bool
    {
        try {
            return $this->model->where($conditions)->exists();
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while checking for record existence.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while checking for record existence.", previous: $exception);
        }
    }

    /**
     * Get the total count of records.
     *
     * @param  array<int, array> $conditions        The conditions for filtering the records.
     * @return int                                  The total count of records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException If there is an error while counting the records.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException      If there is an error while counting the records.
     */
    public function count(array $conditions): int
    {
        try {
            return $this->model->where($conditions)->count();
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while counting the records.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while counting the records.", previous: $exception);
        }
    }

    /**
     * Get records based on the given conditions.
     *
     * @param  array<int, array> $conditions            The conditions for filtering the records.
     * @param array              $columns               The columns to select.
     * @return \Illuminate\Database\Eloquent\Collection The collection of filtered records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException     If there is an error while retrieving the records.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException          If there is an error while retrieving the records.
     */
    public function where(array $conditions, array $columns = ['*']): Collection
    {
        try {
            // return parent::filter($conditions)->select($columns)->get();
            return $this->model->select($columns)->where($conditions)->get();
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while retrieving the records.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while retrieving the records.", previous: $exception);
        }
    }

    /**
     * Get all soft-deleted records.
     *
     * @param  array $columns      The columns to select.
     * @return mixed               The collection of soft-deleted records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException If there is an error while retrieving the soft-deleted records.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException      If there is an error while retrieving the soft-deleted records.
     */
    public function trash(array $columns = ['*'])
    {
        try {
            return $this->model->select($columns)->onlyTrashed()->paginate(5);
        } catch (QueryException $exception) {
            throw new QueryException(message: "Error while retrieving the soft-deleted records.", previous: $exception);
        } catch (Throwable $exception) {
            throw new RepositoryException(message: "Error while retrieving the soft-deleted records.", previous: $exception);
        }
    }

}
