<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Repositories\Contracts;


/**
 * ***`ReadWriteRepositoryInterface`***
 *
 * The `ReadWriteRepositoryInterface` defines the contract for a repository that supports both read and write operations.
 * It specifies the methods that can be implemented to retrieve, create, update, and delete data.
 *
 * @package ***`LaravelCoreModule\CoreModuleMaker\Repositories\Contracts`***
 */
interface ReadWriteRepositoryInterface extends ReadOnlyRepositoryInterface
{
    /**
     * Set the model associated with the repository.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $model The model instance.
     * @return void
     */
    public function setModel(?\Illuminate\Database\Eloquent\Model $model): void;

    /**
     * Get the model associated with the repository.
     *
     * @return \Illuminate\Database\Eloquent\Model|null The model instance.
     */
    public function getModel(): ?\Illuminate\Database\Eloquent\Model;

    /**
     * Get the name of the model associated with the repository.
     *
     * @return string The model name.
     */
    public function getModelName(): ?string;

    /**
     * Create a new record.
     *
     * @param  array $data                           The data for creating the record.
     * @return \Illuminate\Database\Eloquent\Model   The created record.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException  If there is an error while creating the record.
     */
    public function create(array $data): \Illuminate\Database\Eloquent\Model;

    /**
     * Update an existing record.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string    $id       The ID of the record to update.
     * @param  array                                         $data     The data for updating the record.
     * @return bool|\Illuminate\Database\Eloquent\Model|null           Whether the update was successful or not.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException                             If the record with the given ID is not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException                    If there is an error while updating the record.
     */
    public function update($id, array $data);

    /**
     * Attach a related model to the record.
     *
     * @param  array<int, mixed> $ids                                The ID or IDs of the record(s).
     * @param  string            $relation                           The name of the relation.
     * @param  mixed             $relatedId                          The ID of the related model to attach.
     * @return bool                                                  Whether the attachment was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  If the record with the given ID or the related model is not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException                  If there is an error while attaching the related model.
     */
    public function attach(array $ids, string $relation, $relatedId): bool;

    /**
     * Detach a related model from the record.
     *
     * @param  array<int, mixed> $ids                                The ID or IDs of the record(s).
     * @param  string            $relation                           The name of the relation.
     * @param  mixed             $relatedId                          The ID of the related model to detach.
     * @return bool                                                  Whether the detachment was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  If the record with the given ID or the related model is not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException                  If there is an error while detaching the related model.
     */
    public function detach(array $ids, string $relation, $relatedId): bool;

    /**
     * Associate a related model with the record.
     *
     * @param  Illuminate\Database\Eloquent\Model|string $id                                      The ID of the record.
     * @param  string       $relation                                The name of the relation.
     * @param  mixed        $relatedId                               The ID of the related model to associate.
     * @return bool|Illuminate\Database\Eloquent\Model                                            Whether the association was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  If the record with the given ID or the related model is not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException                  If there is an error while associating the related model.
     */
    public function associate($id, string $relation, $relatedId);

    /**
     * Soft delete one or more records.
     *
     * @param  string|array $ids                                     The ID or IDs of the record(s) to soft delete.
     * @return bool                                                  Whether the soft delete was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  If any of the records with the given IDs are not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException                  If there is an error while performing the soft delete.
     */
    public function softDelete($ids);

    /**
     * Permanently delete one or more soft deleted records.
     *
     * @param  string|array $ids                                     The ID or IDs of the record(s) to permanently delete.
     * @return bool                                                  Whether the permanent deletion was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  If any of the soft deleted records with the given IDs are not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException                  If there is an error while performing the permanent deletion.
     */
    public function permanentlyDelete($ids): bool;

    /**
     * Restore one or more soft deleted records.
     *
     * @param  string|array $ids                                     The ID or IDs of the soft deleted record(s) to restore.
     * @return bool                                                  Whether the restoration of all soft deleted records was successful.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  If any of the soft deleted records with the given IDs are not found.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException                  If there is an error while restoring the soft deleted records.
     */
    public function restore($ids): bool;

    /**
     * Restore all soft deleted records.
     *
     * @return bool                                  Whether the restoration of all soft deleted records was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException  If there is an error while restoring all soft deleted records.
     */
    public function restoreAll(): bool;

    /**
     * Empty the trash by permanently deleting all soft deleted records.
     *
     * @return bool                                  Whether the emptying of trash was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException  If there is an error while emptying the trash.
     */
    public function emptyTrash(): bool;

    /**
     * Permanently delete all records.
     *
     * @return bool                                  Whether the permanent deletion of all records was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\RepositoryException  If there is an error while performing the permanent deletion.
     */
    public function permanentlyDeleteAll(): bool;

}
