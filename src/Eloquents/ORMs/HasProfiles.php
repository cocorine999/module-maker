<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs;

use App\Models\Administrateur;
use App\Models\Profile;
use App\Models\Role;


/**
 * Trait ***`HasProfiles`***
 *
 * This trait provides methods to work with user profiles and their relationships.
 *
 * @package ***`LaravelCoreModule\CoreModuleMaker\Eloquents\ORMs`***
 */
trait HasProfiles
{

    /**
     * Get the profiles associated with the current user model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Profile::class, 'user_id');
    }

    /**
     * Get the roles associated with the current user model through profiles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function roles(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Role::class, Profile::class, 'user_id', 'id', 'id', 'role_id');
    }

    /**
     * Scope a query to only include profiles of a specific type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  The Eloquent query builder instance.
     * @param  string                                 $type   The type of profile to include.
     * @return \Illuminate\Database\Eloquent\Builder          The modified query builder instance.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('profileable_type', $type);
    }

    /**
     * Scope a query to include the profileable model instance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  The Eloquent query builder instance.
     * @return \Illuminate\Database\Eloquent\Builder          The modified query builder instance.
     */
    public function scopeWithProfileable(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->with('profileable');
    }

    /**
     * Scope a query to include profiles of a specific type through the profileable model instance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  The Eloquent query builder instance.
     * @param  string                                 $type   The type of profile to include.
     * @return \Illuminate\Database\Eloquent\Builder          The modified query builder instance.
     */
    public function scopeWhereProfileable(\Illuminate\Database\Eloquent\Builder $query, $type): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereHas('profileable', function ($query) use ($type) {
                    $query->whereInstanceOf($type);
                })->withProfileable();
    }
    
    /**
     * Scope a query to include profiles of a specific type through the profileable model instance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query The Eloquent query builder instance.
     * @param  string $type The type of profile to include.
     * @return \Illuminate\Database\Eloquent\Builder The modified query builder instance.
     */
    public function scopeProfileable(\Illuminate\Database\Eloquent\Builder $query, string $type): \Illuminate\Database\Eloquent\Builder
    {
        return $query;
        return $query->whereProfileable($type)->first()->profileable();
    }

    /**
     * Check if the user model has a profile of the given type.
     *
     * @param  string $profileType The type of profile to check for.
     * @return bool True if the user has a profile of the given type, otherwise false.
     */
    public function hasTypeProfile(string $profileType): bool
    {
        return $this->profiles()->ofType($profileType)->exists();
    }

    /**
     * Check if the user model has a profile of the given class.
     *
     * @param  string  $profileClass The class name of the profile to check for.
     * @return bool True if the user has a profile of the given class, otherwise false.
     */
    public function hasProfileByClass(string $profileClass): bool
    {
        return $this->profiles()
                    ->profileable($profileClass)
                    ->exists();
    }

    /**
     * Get the profile associated with the model.
     *
     * @param  string $profileClass
     * @return \App\Models\Profile|null
     */
    public function getProfile($profileClass)
    {
        return $this->profiles()
                    ->profileable($profileClass)
                    ->first();
    }

    /**
     * Check if the model has a client profile.
     *
     * @return bool
     */
    public function hasClientProfile()
    {
        return $this->hasProfile(Client::class);
    }

    /**
     * Check if the model has a locataire profile.
     *
     * @return bool
     */
    public function hasLocataireProfile()
    {
        return $this->hasProfile(Locataire::class);
    }

    /**
     * Check if the model has a proprietaire profile.
     *
     * @return bool
     */
    public function hasProprietaireProfile()
    {
        return $this->hasProfile(Proprietaire::class);
    }

    /**
     * Check if the model has a gestionnaire profile.
     *
     * @return bool
     */
    public function hasGestionnaireProfile()
    {
        return $this->hasProfile(Gestionnaire::class);
    }

    /**
     * Check if the model has an administrator profile.
     *
     * @return bool
     */
    public function hasAdministratorProfile()
    {
        return $this->hasProfile(Administrateur::class);
    }

    /**
     * Check if the model has an super_administrator profile.
     *
     * @return bool
     */
    public function hasSuperAdministratorProfile()
    {
        return $this->hasProfile(SuperAdministrateur::class);
    }

    /**
     * Get the client profile associated with the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function clientProfile()
    {
        return $this->hasOneThrough(Client::class, Profile::class, 'user_id', 'id', 'id', 'profileable_id');
    }

    /**
     * Get the locataire profile associated with the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function locataireProfile()
    {
        return $this->hasOneThrough(Locataire::class, Profile::class, 'user_id', 'id', 'id', 'profileable_id');
    }

    /**
     * Get the proprietaire profile associated with the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function proprietaireProfile()
    {
        return $this->hasOneThrough(Proprietaire::class, Profile::class, 'user_id', 'id', 'id', 'profileable_id');
    }

    /**
     * Get the gestionnaire profile associated with the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function gestionnaireProfile()
    {
        return $this->hasOneThrough(Gestionnaire::class, Profile::class, 'user_id', 'id', 'id', 'profileable_id');
    }

    /**
     * Get the administrator profile associated with the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function administratorProfile()
    {
        return $this->hasOneThrough(Administrateur::class, Profile::class, 'user_id', 'id', 'id', 'profileable_id');
    }

    /**
     * Get the super administrator profile associated with the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function superAdministratorProfile()
    {
        return $this->hasOneThrough(SuperAdministrateur::class, Profile::class, 'user_id', 'id', 'id', 'profileable_id');
    }

    /**
     * Create a profile for the model.
     *
     * @param  string $profileClass
     * @param  array  $data
     * @return \App\Models\Client|\App\Models\Locataire|\App\Models\Gestionnaire|\App\Models\Proprietaire|\App\Models\Administrateur|\App\Models\SuperAdministrateur|null
     */
    public function createProfile($profileClass, array $data = [])
    {

        $profile = new $profileClass($data);

        $class_name = convert_to_kebab_case( str_replace(["App", "Models", "\\"], '', $profileClass));

        $role_id = Role::where("slug", "{$class_name}_slug")->value('id');

        dd( $profile->profile()->create(['user_id' => $this->id, 'role_id' => $role_id]));

        $profile->profile()->create(['profileable_id' => $profile->id, 'user_id' => $this->id, 'role_id' => $role_id, 'can_be_detach' => in_array($class_name, ['client', 'super_adminitrator']) ? false : true]);

        $this->assignRole($role_id);

        return $profile;
    }

}