<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Services\Contracts;


/**
 * ***`ReadWriteServiceContract implements QueryServiceContract`***
 *
 * This interface defines the contract for a write service that provides methods to create, update, and delete records.
 *
 * **Definition:**
 * The ReadWriteServiceContract implements QueryServiceContract interface defines the contract for a service that handles the creation, updating, and deletion of records.
 * It includes the following methods:
 *
 * **Methods:**
 * 1. `\Illuminate\Database\Eloquent\Model|null create(\LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $data)`:           Creates a new record
 * 2. `bool|\Illuminate\Database\Eloquent\Model|null update($id, \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $data)`: Update an existing record.
 * 3. `bool softDelete(array $ids)`:                                                Soft delete one or more records.
 * 4. `bool permanentlyDelete(array $ids): bool`                                    Permanently delete one or more soft deleted records.
 * 5. `bool restore(array $ids): bool`:                                             Restore one or more soft deleted records.
 * 6. `bool restoreAll(): bool`:                                                    Restore all soft deleted records.
 * 7. `bool permanentlyDeleteAll(): bool`:                                          Permanently delete all soft deleted records.
 * 8. `bool emptyTrash(): bool`:                                                    Empty the trash records.
 *
 * @package ***\LaravelCoreModule\CoreModuleMaker\Services\Contracts.***
 */
interface ReadWriteServiceContract extends QueryServiceContract
{
    /**
     * Create a new record.
     *
     * @param  \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $data  The data for creating the record.
     * @return \Illuminate\Database\Eloquent\Model|null                                    The created record.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException              If there is an error while creating the record.
     */
    public function create(\LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $data);

    /**
     * Update an existing record.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string     $id    The ID of the record to update.
     * @param  \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface        $data  The data for updating the record.
     * @return bool|\Illuminate\Database\Eloquent\Model|null                               Whether the update was successful or not.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                     If there is an error while updating the record.
     */
    public function update($id, \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $data);

    /**
     * Soft delete one or more records.
     *
     * @param  string|array $ids                                    The ID or IDs of the record(s) to soft delete.
     * @return bool                                                 Whether the soft delete was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                    If there is an error while performing the soft delete.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If any of the records with the given IDs are not found.
     */
    public function softDelete($ids);

    /**
     * Permanently delete one or more soft deleted records.
     *
     * @param  string|array $ids                                    The ID or IDs of the record(s) to permanently delete.
     * @return bool                                                 Whether the permanent deletion was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If any of the soft deleted records with the given IDs are not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                    If there is an error while performing the permanent deletion.
     */
    public function permanentlyDelete($ids): bool;

    /**
     * Restore one or more soft deleted records.
     *
     * @param  string|array $ids                                    The ID or IDs of the soft deleted record(s) to restore.
     * @return bool                                                 Whether the restoration of all soft deleted records was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If any of the soft deleted records with the given IDs are not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException                    If there is an error while restoring the soft deleted records.
     */
    public function restore($ids): bool;

    /**
     * Restore all soft deleted records.
     *
     * @return bool                              Whether the restoration of all soft deleted records was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while restoring all soft deleted records.
     */
    public function restoreAll(): bool;

    /**
     * Empty the trash by permanently deleting all soft deleted records.
     *
     * @return bool                              Whether the emptying of trash was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while emptying the trash.
     */
    public function emptyTrash(): bool;

    /**
     * Permanently delete all records.
     *
     * @return bool                              Whether the permanent deletion of all records was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while performing the permanent deletion.
     */
    public function permanentlyDeleteAll(): bool;
}
