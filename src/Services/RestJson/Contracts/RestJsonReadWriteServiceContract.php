<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Services\RestJson\Contracts;


/**
 * **`RestJsonReadWriteServiceContract`**
 *
 * The `RestJsonReadWriteServiceContract` interface defines methods for performing write operations on records and returning the results as JSON responses.
 *
 * @package **\LaravelCoreModule\CoreModuleMaker\Services\Contracts.**
 */
interface RestJsonReadWriteServiceContract extends RestJsonQueryServiceContract
{

    /**
     * Set the read-write service associated with the service.
     *
     * @param \LaravelCoreModule\CoreModuleMaker\Services\Contracts\ReadWriteServiceContract $service The read-write service instance.
     * @return void
     */
    public function setReadWriteService(\LaravelCoreModule\CoreModuleMaker\Services\Contracts\ReadWriteServiceContract $service): void;

    /**
     * Get the read-write service associated with the service.
     *
     * @return \LaravelCoreModule\CoreModuleMaker\Services\Contracts\ReadWriteServiceContract The read-write service instance.
     */
    public function getReadWriteService(): \LaravelCoreModule\CoreModuleMaker\Services\Contracts\ReadWriteServiceContract;


    /**
     * Create a new record.
     *
     * @param  \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $data The data for creating the record.
     * @return \Illuminate\Http\JsonResponse                 The JSON response indicating whether the create was successful or not.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException             If there is an error while creating the record.
     */
    public function create(\LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $data): \Illuminate\Http\JsonResponse;

    /**
     * Update an existing record.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string $id                              The ID of the record to update.
     * @param  \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $data   The data for updating the record.
     * @return \Illuminate\Http\JsonResponse                   The JSON response indicating whether the update was successful or not.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException               If there is an error while updating the record.
     */
    public function update($id, \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $data): \Illuminate\Http\JsonResponse;

    /**
     * Soft delete one or more records.
     *
     * @param  string|array $ids                                     The ID or IDs of the record(s) to soft delete.
     * @return \Illuminate\Http\JsonResponse                         The JSON response indicating whether the soft delete was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  If any of the records with the given IDs are not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                     If there is an error while performing the soft delete.
     */
    public function softDelete($ids): \Illuminate\Http\JsonResponse;

    /**
     * Permanently delete one or more soft deleted records.
     *
     * @param  string|array $ids                                     The ID or IDs of the record(s) to permanently delete.
     * @return \Illuminate\Http\JsonResponse                         The JSON response indicating whether the permanent deletion was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  If any of the soft deleted records with the given IDs are not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                     If there is an error while performing the permanent deletion.
     */
    public function permanentlyDelete($ids): \Illuminate\Http\JsonResponse;

    /**
     * Restore one or more soft deleted records.
     *
     * @param  string|array $ids                                     The ID or IDs of the soft deleted record(s) to restore.
     * @return \Illuminate\Http\JsonResponse                         The JSON response indicating whether the restoration of all soft deleted records was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  If any of the soft deleted records with the given IDs are not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                     If there is an error while restoring the soft deleted records.
     */
    public function restore($ids): \Illuminate\Http\JsonResponse;

    /**
     * Restore all soft deleted records.
     *
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating whether the restoration of all soft deleted records was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while restoring all soft deleted records.
     */
    public function restoreAll(): \Illuminate\Http\JsonResponse;

    /**
     * Empty the trash by permanently deleting all soft deleted records.
     *
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating whether the emptying of trash was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while emptying the trash.
     */
    public function emptyTrash(): \Illuminate\Http\JsonResponse;

    /**
     * Permanently delete all records.
     *
     * @return \Illuminate\Http\JsonResponse     The JSON response indicating whether the permanent deletion of all records was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while performing the permanent deletion.
     */
    public function permanentlyDeleteAll(): \Illuminate\Http\JsonResponse;

}
