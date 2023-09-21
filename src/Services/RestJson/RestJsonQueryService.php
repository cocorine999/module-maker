<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Services\RestJson;

use LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException;
use LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Responses\Json\JsonResponseTrait;
use LaravelCoreModule\CoreModuleMaker\Services\Contracts\QueryServiceContract;
use LaravelCoreModule\CoreModuleMaker\Services\RestJson\Contracts\RestJsonQueryServiceContract;
use Illuminate\Database\Eloquent\Model;
use Throwable;


/**
 * Class `RestJsonQueryService`
 *
 * The `RestJsonQueryService` class is an abstract class that provides a concrete implementation of the `RestJsonQueryServiceContract`.
 * It extends the `QueryService` class and adds methods for retrieving records in a `RESTful` JSON format.
 * This class is responsible for retrieving all records, `paginating` records, `finding` records by ID, `filtering` records based on `criteria`, `counting` records, and `retrieving` soft deleted records.
 *
 * @package \LaravelCoreModule\CoreModuleMaker\Services\RestJson
 */
abstract class RestJsonQueryService implements RestJsonQueryServiceContract
{

    /**
     * The query service instance.
     *
     * @var \LaravelCoreModule\CoreModuleMaker\Services\Contracts\QueryServiceContract|null
     */
    protected QueryServiceContract $queryService;


    public function __construct(QueryServiceContract $queryService)
    {
        $this->queryService = $queryService;
    }

    /**
     * Set the read-only service associated with the service.
     *
     * @param  \LaravelCoreModule\CoreModuleMaker\Services\Contracts\QueryServiceContract $service The read-only service instance.
     * @return void
     */
    public function setReadOnlyService(QueryServiceContract $service): void
    {
        $this->queryService = $service;
    }

    /**
     * Get the read-only service associated with the service.
     *
     * @return \LaravelCoreModule\CoreModuleMaker\Services\Contracts\QueryServiceContract The read-only service instance.
     */
    public function getReadOnlyService(): \LaravelCoreModule\CoreModuleMaker\Services\Contracts\QueryServiceContract
    {
        return $this->queryService;
    }


    /**
     * Get all records.
     *
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of all records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error retrieving the records.
     */
    public function all(array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->all($columns));
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Paginate the records.
     *
     *
     * @param  int        $perPage               The number of results to display per page.
     * @param  string     $pageName              The query string variable used to store the current page.
     * @param  int|null   $page                  The current page number.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of paginated records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error paginating the records.
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->paginate($perPage, $columns, $pageName, $page));
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Find a record by its ID.
     *
     * @param  Model|string $id                  The ID of the record.
     * @param  array        $columns             The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the found record, or null if not found.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error finding the record.
     */
    public function findById($id, array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->findById($id, $columns));
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Retrieve data based on the provided query criteria.
     *
     * @param  array $criteria                   The criteria for filtering the records.
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of filtered records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error retrieving the filtered records.
     */
    public function where(array $criteria, array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->where($criteria, $columns));
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Get the total count of records.
     *
     * @param  array $criteria                   The criteria for filtering the records.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the total count of records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error counting the records.
     */
    public function count(array $criteria): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->count($criteria));
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Get all soft deleted records.
     *
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of soft deleted records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error retrieving the soft deleted records.
     */
    public function trash(array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->trash($columns));
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Get all soft deleted records.
     *
     * @param  Model|string $id                  The ID of the record.
     * @param  array        $columns             The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of soft deleted records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error retrieving the soft deleted records.
     */
    public function getTrash($id, array $columns = ['*']): \Illuminate\Http\JsonResponse
    {
        try {
            return JsonResponseTrait::success(data: $this->queryService->getTrash($id, $columns));
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Filter records.
     *
     * @param  array $criteria                   The criteria for filtering the records.
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating whether the permanent deletion of all records was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while performing the permanent deletion.
     */
    public function search(array $criteria, array $columns = ['*']): \Illuminate\Http\JsonResponse
    {

        try {
            return JsonResponseTrait::success(data: $this->queryService->where($criteria, $columns));
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }
}
