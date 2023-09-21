<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Services\Contracts;


/**
 * ***`QueryServiceContract`***
 *
 * This interface defines the contract for a query service, which provides methods for retrieving data from a data source.
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Services\Contracts`***
 */
interface QueryServiceContract
{

    /**
     * Set the repository associated with the service.
     *
     * @param  $repository The model instance.
     * @return void
     */
    public function setRepository($repository): void;

    /**
     * Get the repository associated with the repository.
     *
     * @return The repository instance.
     */
    public function getRepository();

    /**
     * Get all records.
     *
     * @param  array $columns                                   The columns to select.
     * @return \Illuminate\Database\Eloquent\Collection         The collection of all records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                If there is an error retrieving the records.
     */
    public function all(array $columns = ['*']);

    /**
     * Paginate the records.
     *
     *
     * @param  int        $perPage                              The number of results to display per page.
     * @param  string     $pageName                             The query string variable used to store the current page.
     * @param  int|null   $page                                 The current page number.
     * @return mixed                                            The collection of paginated records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                If there is an error paginating the records.
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null);

    /**
     * Find a record by its ID.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string $id   The ID of the record.
     * @param  array        $columns                            The columns to select.
     * @return mixed                                            The found record, or null if not found.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                If there is an error finding the record.
     */
    public function findById($id, array $columns = ['*']);

    /**
     * Retrieve data based on the provided query criteria.
     *
     * @param  array $criteria                                  The criteria for filtering the records.
     * @param  array $columns                                   The columns to select.
     * @return \Illuminate\Database\Eloquent\Collection         The collection of filtered records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                If there is an error retrieving the filtered records.
     */
    public function where(array $criteria, array $columns = ['*']);

    /**
     * Get the total count of records.
     *
     * @param  array $criteria                                  The criteria for filtering the records.
     * @return int                                              The total count of records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                If there is an error counting the records.
     */
    public function count(array $criteria): int;

    /**
     * Perform a custom query or action.
     *
     * @param  string           $query                          The query or action to perform.
     * @param  array            $params                         Additional parameters for the query.
     * @return mixed                                            The result of the query or action.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                If there is an error executing the custom query or action.
     */
    public function executeQuery(string $query, array $params = []);

    /**
     * Get all soft-deleted records.
     *
     * @param  array $columns                                   The columns to select.
     * @return mixed                                            The collection of soft-deleted records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException             If there is an error while retrieving the soft-deleted records.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\QueryException                  If there is an error while retrieving the soft-deleted records.
     */
    public function trash(array $columns = ['*']);

    /**
     * Get all soft deleted records.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string  $id       The ID of the record.
     * @param  array                                       $columns  The columns to select.
     * @return \Illuminate\Database\Eloquent\Model|null              The collection of soft deleted records.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error retrieving the soft deleted records.
     */
    public function getTrash($id, array $columns = ['*']): ?\Illuminate\Database\Eloquent\Model;
}
