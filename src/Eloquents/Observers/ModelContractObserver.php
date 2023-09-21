<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\Observers;

use LaravelCoreModule\CoreModuleMaker\Eloquents\Contract\ModelContract;
use Illuminate\Validation\UnauthorizedException;

/**
 * ModelContractObserver
 *
 * This class serves as an observer for model contract events.
 * It provides a convenient way to hook into and handle various model events.
 */
class ModelContractObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = false;


    /**
     * Listen to the saving event.
     *
     * Handle the ModelContract "saving" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function saving(ModelContract $model): void
    {

    }


    /**
     * Listen to the saved event.
     *
     * Handle the ModelContract "saved" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function saved(ModelContract $model): void
    {
        
    }


    /**
     * Listen to the retrieving event.
     *
     * Handle the ModelContract "retrieving" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function retrieving(ModelContract $model): void
    {
        //
    }


    /**
     * Listen to the retrieved event.
     *
     * Handle the ModelContract "retrieved" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function retrieved(ModelContract $model): void
    {
        //
    }


    /**
     * Listen to the creating event.
     *
     * Handle the ModelContract "creating" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function creating(ModelContract $model): void
    {

    }


    /**
     * Listen to the created event.
     *
     * Handle the ModelContract "created" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function created(ModelContract $model): void
    {
        //
    }


    /**
     * Listen to the updating event.
     *
     * Handle the ModelContract "updating" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function updating(ModelContract $model): void
    {
        //
    }


    /**
     * Listen to the updated event.
     *
     * Handle the ModelContract "updated" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function updated(ModelContract $model): void
    {

    }


    /**
     * Listen to the deleting event.
     *
     * Handle the ModelContract "deleting" event.
     *
     * @param ModelContract $model The model instance.
     * return void
     */
    public function deleting(ModelContract $model)
    {
        dd($model);
        if (!(in_array($model->deleteable(), $model->getFillable()) && $model->{$model->deleteable()})) {
            // Prevent the deletion from happening by returning false
            return false;
            throw new UnauthorizedException('The record cannot be deleted.');
        }
    }


    /**
     * Listen to the deleted event.
     *
     * Handle the ModelContract "deleted" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function deleted(ModelContract $model): void
    {

    }


    /**
     * Listen to the restoring event.
     *
     * Handle the ModelContract "restoring" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function restoring(ModelContract $model): void
    {
        //
    }


    /**
     * Listen to the restored event.
     *
     * Handle the ModelContract "restored" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function restored(ModelContract $model): void
    {
        //
    }


    /**
     * Listen to the forceDeleting event.
     *
     * Handle the ModelContract "forceDeleting" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function forceDeleting(ModelContract $model): void
    {
        $model->statut = false;
    }

    /**
     * Handle the ModelContract "force deleted" event.
     */
    /**
     * Listen to the forceDeleting event.
     *
     * Handle the ModelContract "forceDeleting" event.
     *
     * @param ModelContract $model The model instance.
     * @return void
     */
    public function forceDeleted(ModelContract $model): void
    {
        if (!(in_array($model->deleteable(), $model->getFillable()) && $model->{$model->deleteable()})) {
            // Prevent the deletion from happening by returning false
            throw new UnauthorizedException('The record cannot be deleted.');
        }
    }
}
