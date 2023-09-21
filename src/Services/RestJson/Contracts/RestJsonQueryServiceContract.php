<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Services\RestJson\Contracts;


/**
 * Interface ***`RestJsonQueryServiceContract`***
 * 
 * The `RestJsonQueryServiceContract` interface defines methods for retrieving data in a RESTful JSON format. Each method returns a JSON response containing the requested data or information about the operation.
 *
 * When implementing this interface, each method should be responsible for retrieving the relevant data and returning it as a JSON response using the `Illuminate\Http\JsonResponse` class.
 * The JSON response should be formatted according to the RESTful API standards, including appropriate HTTP status
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Services\RestJson\Contracts`***
 */
interface RestJsonQueryServiceContract
{

    /**
     * Set the read-only service associated with the service.
     *
     * @param \LaravelCoreModule\CoreModuleMaker\Services\Contracts\QueryServiceContract $service The read-only service instance.
     * @return void
     */
    public function setReadOnlyService(\LaravelCoreModule\CoreModuleMaker\Services\Contracts\QueryServiceContract $service): void;

    /**
     * Get the read-only service associated with the service.
     *
     * @return \LaravelCoreModule\CoreModuleMaker\Services\Contracts\QueryServiceContract The read-only service instance.
     */
    public function getReadOnlyService(): \LaravelCoreModule\CoreModuleMaker\Services\Contracts\QueryServiceContract;

    /**
     * Get all records.
     *
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of all records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error retrieving the records.
     */
    public function all(array $columns = ['*']): \Illuminate\Http\JsonResponse;

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
    public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null): \Illuminate\Http\JsonResponse;

    /**
     * Find a record by its ID.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string $id       The ID of the record.
     * @param  array                                      $columns  The columns to select.
     * @return \Illuminate\Http\JsonResponse                        The JSON response containing the found record, or null if not found.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                    If there is an error finding the record.
     */
    public function findById($id, array $columns = ['*']): \Illuminate\Http\JsonResponse;

    /**
     * Retrieve data based on the provided query criteria.
     *
     * @param  array $criteria                   The criteria for filtering the records.
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of filtered records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error retrieving the filtered records.
     */
    public function where(array $criteria, array $columns = ['*']): \Illuminate\Http\JsonResponse;

    /**
     * Get the total count of records.
     *
     * @param  array $criteria                   The criteria for filtering the records.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the total count of records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error counting the records.
     */
    public function count(array $criteria): \Illuminate\Http\JsonResponse;

    /**
     * Get all soft deleted records.
     *
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response containing the collection of soft deleted records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error retrieving the soft deleted records.
     */
    public function trash(array $columns = ['*']): \Illuminate\Http\JsonResponse;

    /**
     * Get all soft deleted records.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string $id       The ID of the record.
     * @param  array                                      $columns  The columns to select.
     * @return \Illuminate\Http\JsonResponse                        The JSON response containing the collection of soft deleted records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                    If there is an error retrieving the soft deleted records.
     */
    public function getTrash($id, array $columns = ['*']): \Illuminate\Http\JsonResponse;

    /**
     * Filter records.
     *
     * @param  array $criteria                   The criteria for filtering the records.
     * @param  array $columns                    The columns to select.
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating whether the permanent deletion of all records was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while performing the permanent deletion.
     */
    public function search(array $criteria, array $columns = ['*']): \Illuminate\Http\JsonResponse;
}
