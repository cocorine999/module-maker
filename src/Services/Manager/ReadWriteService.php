<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Services\Manager;

use LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface;
use LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException;
use LaravelCoreModule\CoreModuleMaker\Repositories\Contracts\ReadWriteRepositoryInterface;
use LaravelCoreModule\CoreModuleMaker\Services\Contracts\ReadWriteServiceContract;
use Illuminate\Database\Eloquent\Model;
use Throwable;


/**
 * Class `ReadWriteService`
 *
 * The `ReadWriteService` class provides a concrete implementation of the `ReadWriteServiceContract`.
 * It extends the `QueryService` class and adds write operations to manipulate data using the associated `ReadWriteRepositoryInterface`.
 * This class is responsible for creating, updating, soft deleting, restoring, and permanently deleting records.
 *
 * @package \LaravelCoreModule\CoreModuleMaker\Services\Manager
 */
class ReadWriteService extends QueryService implements ReadWriteServiceContract
{

    /**
     * The read-write repository for accessing and manipulating data.
     *
     * @var \LaravelCoreModule\CoreModuleMaker\Repositories\Contracts\ReadWriteRepositoryInterface|null
     */
    protected ReadWriteRepositoryInterface $readWriteRepository;

    /**
     * Constructor for the ReadWriteService abstract class.
     *
     * @param ReadWriteRepositoryInterface $readWriteRepository The read-write repository to be used for querying, retrieving and writing records.
     */
    public function __construct(ReadWriteRepositoryInterface $readWriteRepository)
    {
        parent::__construct($readWriteRepository);
        $this->readWriteRepository = $readWriteRepository;
    }

    /**
     * Create a new record.
     *
     * @param  \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $data The data for creating the record.
     * @return Model|null                                    The created record.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException             If there is an error while creating the record.
     */
    public function create(DTOInterface $data)
    {
        try {
            return $this->readWriteRepository->create($data->toArray());
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Update an existing record.
     *
     * @param  Model|string           $id                    The ID of the record to update.
     * @param  \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $data The data for updating the record.
     * @return bool|Model|null                               Whether the update was successful or not.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException             If there is an error while updating the record.
     */
    public function update($id, DTOInterface $data)
    {
        try {
            return $this->readWriteRepository->update($id, $data->toArray());
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Soft delete one or more records.
     *
     * @param  string|array $ids                The ID or IDs of the record(s) to soft delete.
     * @return bool                             Whether the soft delete was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while performing the soft delete.
     */
    public function softDelete($ids)
    {
        try {
            return $this->readWriteRepository->softDelete($ids);
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Permanently delete one or more soft deleted records.
     *
     * @param  string|array $ids                The ID or IDs of the record(s) to permanently delete.
     * @return bool                             Whether the permanent deletion was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while performing the permanent deletion.
     */
    public function permanentlyDelete($ids): bool
    {
        try {
            return $this->readWriteRepository->permanentlyDelete($ids);
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Restore one or more soft deleted records.
     *
     * @param  string|array $ids                The ID or IDs of the soft deleted record(s) to restore.
     * @return bool                             Whether the restoration of all soft deleted records was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while restoring the soft deleted records.
     */
    public function restore($ids): bool
    {
        try {
            return $this->readWriteRepository->restore($ids);
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Restore all soft deleted records.
     *
     * @return bool                             Whether the restoration of all soft deleted records was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while restoring all soft deleted records.
     */
    public function restoreAll(): bool
    {
        try {
            return $this->readWriteRepository->restoreAll();
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Empty the trash by permanently deleting all soft deleted records.
     *
     * @return bool                             Whether the emptying of trash was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while emptying the trash.
     */
    public function emptyTrash(): bool
    {
        try {
            return $this->readWriteRepository->emptyTrash();
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }

    /**
     * Permanently delete all records.
     *
     * @return bool                             Whether the permanent deletion of all records was successful.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\ServiceException If there is an error while performing the permanent deletion.
     */
    public function permanentlyDeleteAll(): bool
    {
        try {
            return $this->readWriteRepository->permanentlyDeleteAll();
        } catch (Throwable $exception) {
            throw new ServiceException(message: $exception->getMessage(), previous: $exception);
        }
    }
}
