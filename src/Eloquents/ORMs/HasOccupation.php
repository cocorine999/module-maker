<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs;

use Illuminate\Database\Eloquent\Builder;

trait HasOccupation
{
    /**
     * Get all occupations associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function occupations(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Occupation::class, 'occupationable');
    }

    /**
     * Get the active occupation associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function activeOccupation(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(\App\Models\Occupation::class, 'occupationable')->where('status', true);
    }

    /**
     * Set an occupation as active for the model.
     *
     * @param \App\Models\Occupation $occupation
     * @return void
     */
    public function setActiveOccupation(\App\Models\Occupation $occupation): void
    {
        // Deactivate any existing active occupation
        $this->occupations()->update(['status' => false]);

        // Set the new occupation as active
        $occupation->update(['status' => true]);

        // Associate the occupation with the user
        $this->occupations()->save($occupation);
    }

    /**
     * Get the occupation name.
     *
     * @return string|null
     */
    public function getOccupationName()
    {
        return $this->occupation ? $this->occupation->occupation_details : null;
    }

    /**
     * Scope the query to include the occupation when retrieving models.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithOccupation(Builder $query)
    {
        return $query->with('occupation');
    }

    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootHasOccupation()
    {
        static::creating(function ($model) {
            if (!$model->isValidOccupation()) {
                throw new \Exception('Invalid occupation data.');
            }
        });
    }

    /**
     * Check if the model has a valid occupation associated with it.
     *
     * @return bool
     */
    public function isValidOccupation()
    {
        // Implement your custom validation logic here
        return $this->activeOccupation() !== null;
    }
}
