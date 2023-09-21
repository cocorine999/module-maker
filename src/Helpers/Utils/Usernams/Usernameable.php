<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Usernameable;

use Illuminate\Database\Eloquent\Model;


/**
 * Trait Usernameable
 *
 * The `Usernameable` trait automatically generates unique usernames for model instances.
 *
 * @package LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Usernameable
 */
trait Usernameable
{
    /**
     * Boot the Usernameable trait for the model.
     *
     * @return void
     */
    public static function bootUsernameable(): void
    {
        static::creating(function (Model $model) {
            if ($model->hasUsernameAttribute() && $model->shouldGenerateUsername()) {
                $model->generateUsername();
            }
        });
    }

    /**
     * Determine if the model has a username attribute.
     *
     * @return bool
     */
    protected function hasUsernameAttribute(): bool
    {
        return property_exists($this, 'usernameAttribute');
    }

    /**
     * Determine if the username should be generated for the model.
     *
     * @return bool
     */
    protected function shouldGenerateUsername(): bool
    {
        $usernameAttribute = $this->getAttribute('usernameAttribute');

        return empty($usernameAttribute);
    }

    /**
     * Generate the username and set it on the model.
     *
     * @return void
     */
    protected function generateUsername(): void
    {
        $username = $this->makeUniqueUsername();

        if (!empty($username)) {
            $this->setAttribute('usernameAttribute', $username);
        }
    }

    /**
     * Make the generated username unique by appending a suffix.
     *
     * @param string $username
     * @param int $suffix
     * @return string
     */
    protected function makeUniqueUsername(string $username = '', int $suffix = 0): string
    {
        if (empty($username)) {
            // Generate the initial username based on the model's attributes.
            $username = $this->generateUsernameFromAttributes();
        }

        if ($suffix > 0) {
            $username .= $suffix;
        }

        $query = static::where('usernameAttribute', '=', $username);

        // Check if the model is being updated (existing) or created (new).
        if ($this->exists && !$this->isDirty('usernameAttribute')) {
            $query->whereKeyNot($this->getKey());
        }

        if ($query->count() > 0) {
            // The username is not unique, generate a new one with an incremented suffix.
            $suffix++;
            return $this->makeUniqueUsername($username, $suffix);
        }

        return $username;
    }

    /**
     * Generate the initial username based on the model's attributes.
     *
     * @return string
     */
    protected function generateUsernameFromAttributes(): string
    {
        // Implement your logic to generate the username based on the model's attributes.
        // For example, you can concatenate the first name and last name.
        // Make sure to handle special characters, spaces, and ensure uniqueness.
        // Example: return strtolower($this->getAttribute('first_name') . '.' . $this->getAttribute('last_name'));
        return strtolower($this->getAttribute('first_name') . '.' . $this->getAttribute('last_name'));
    }
}
