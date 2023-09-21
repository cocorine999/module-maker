<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Usernameable;

use Illuminate\Database\Eloquent\Model;
use LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable\UsernameOptions;

trait HasUsername
{
    use UsernameChangeLog, GeneratesUniqueUsername;

    public static function bootHasUsername()
    {
        static::creating(function (Model $model) {
            $model->username = $model->generateAndSetUsername($model);
        });
    }
    
    /**
     * Generate and set the username based on last_name and first_name.
     *
     * @param  Model  $model
     * @return string
     */
    public function generateAndSetUsername(Model $model): string
    {

        ///dd(json_decode($model->first_name));
        ///dd(implode('value', json_decode($model->first_name)));

        ///dd(str_replace([' '], '', $model->first_name));

        /* $firstName = implode('.', array_map(function ($item) {
            return strtolower($item->value);
        }, json_decode($model->first_name))); */

        ///dd(json_decode($model->first_name)->val);

        // Remove the single quotes and curly braces from both ends of the string
        //$decodedString = trim($model->first_name, "'{}'");

        // Remove any spaces and convert to lowercase
        //$firstName = str_replace([', ', ',', '\''], ['.'], strtolower($decodedString));
        
        //$firstName = $model->first_name; ///implode('.', json_decode($model->first_name));
    
        // Get the last_name and convert to lowercase
        $lastName = strtolower($model->last_name);

        $firstName = strtolower(str_replace([' '], '', $model->first_name));

        // Concatenate first_name and last_name to create the username
        $username = $lastName . $firstName;

        $counter = 1;

        while ($this->usernameExistsCaseInsensitive($username)) {
            $counter++;
            $username .= $counter;
        }

        return $username;
    }

    public function getUsernameTitleCase()
    {
        return ucwords(strtolower($this->attributes['username']));
    }
    
    /**
     * Get the column name used for the username.
     *
     * @return string
     */
    public function getUsernameColumn()
    {
        return 'username'; // Customize this if the column name is different
    }

    /**
     * Set the username attribute for the model.
     *
     * @param string $value
     */
    public function setUsernameAttribute($value)
    {
        // You can customize this logic to format or validate the username
        // before saving it to the database.
        $this->attributes['username'] = $value;
    }

    /**
     * Get the username attribute for the model.
     *
     * @return string
     */
    public function getUsernameAttribute()
    {
        // You can customize this logic to format or validate the username
        // before saving it to the database.
        return $this->getDisplayUsername();
    }
    
    public function getUsernameOrDefault($default = 'Guest')
    {
        return $this->username ?: $default;
    }

    /**
     * Scope a query to find a model by username.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $username
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUsername($query, $username)
    {
        // You can customize this method to search for a model by username
        // using a specific column in your database table.
        return $query->where('username', $username);
    }

    public function getUsersByUsernamePrefix($prefix)
    {
        return static::where('username', 'like', $prefix . '%')->get();
    }

    /**
     * Get the username options for the model.
     *
     * @return UsernameOptions
     */
    /* public function getUsernameOptions(): UsernameOptions{
        return UsernameOptions();
    } */

    
    public function getDisplayUsername()
    {
        return '@' . $this->attributes['username'];
    }

    public function usernameExistsCaseInsensitive($username)
    {
        return static::whereRaw('LOWER(username) = ?', [strtolower($username)])->exists();
    }
    
    public function makeUsernamePublic()
    {
        $this->update(['username_visibility' => true]);
    }

    public function makeUsernamePrivate()
    {
        $this->update(['username_visibility' => false]);
    }

    public function scopeSearchByUsername($query, $username, $exact = false)
    {
        if ($exact) {
            return $query->where('username', $username);
        }

        return $query->where('username', 'like', '%' . $username . '%');
    }

}