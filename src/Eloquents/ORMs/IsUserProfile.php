<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs;

use App\Models\Profile;


/**
 * Trait ***`IsUserProfile`***
 *
 * This trait represents a user profile associated with a model.
 * It provides relationships to access the user profile and the associated user.
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs`***
 */
trait IsUserProfile
{
    /**
     * Get the user profile associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function profile(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Profile::class, 'profileable');
    }

    /**
     * Get the user models associated with the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function users()
    {
        return $this->hasManyThrough(User::class, Profile::class, 'role_id', 'id', 'id', 'user_id');
    }

}