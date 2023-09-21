<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Matriculeable;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;


/**
 * Trait Matriculeable
 *
 * The `Matriculeable` trait automatically generates unique matricule numbers for model instances.
 *
 * @package LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Matriculeable
 */
trait Matriculeable
{
    /**
     * Boot the Matriculeable trait for the model.
     *
     * @return void
     */
    public static function bootMatriculeable(): void
    {
        static::creating(function (Model $model) {
            if ($model->hasMatriculeAttribute() && $model->shouldGenerateMatricule()) {
                $model->generateMatricule();
            }
        });
    }

    /**
     * Get the attribute name used for matricule.
     *
     * @return string
     */
    protected function getMatriculeAttributeName(): string
    {
        return property_exists($this, 'matriculeAttribute') ? $this->matriculeAttribute : 'matricule';
    }

    /**
     * Determine if the model has a matricule attribute.
     *
     * @return bool
     */
    protected function hasMatriculeAttribute(): bool
    {
        return property_exists($this, $this->matriculeAttribute);
    }

    /**
     * Determine if the matricule should be generated for the model.
     *
     * @return bool
     */
    protected function shouldGenerateMatricule(): bool
    {
        $matriculeAttribute = $this->{$this->matriculeAttribute};

        return empty($matriculeAttribute);
    }

    /**
     * Generate the matricule and set it on the model.
     *
     * @return void
     */
    protected function generateMatricule(): void
    {
        $this->{$this->getMatriculeAttributeName()} = $this->makeUniqueMatricule();
    }

    /**
     * Generate a unique username with a given prefix.
     *
     * @param string $prefix The username prefix, e.g., "user"
     * @param int $startSuffix The starting numeric suffix
     * @return string
     */
    function generateUniqueUsername(string $prefix = 'user', int $startSuffix = 1): string
    {
        $username = $prefix . '_' . $startSuffix;

        while (User::where('username', $username)->exists()) {
            $startSuffix++;
            $username = $prefix . '_' . $startSuffix;
        }

        return $username;
    }

    /**
     * Make the generated matricule unique by appending a suffix.
     *
     * @param string $matricule
     * @param int $suffix
     * @return string
     */
    protected function makeUniqueMatricule(string $matricule = '', int $suffix = 0): string
    {
        if (empty($matricule)) {
            // Generate the initial matricule.
            $matricule = 'M-' . strtoupper(substr(uniqid(), -6));
        }

        if ($suffix > 0) {
            $matricule .= '-' . $suffix;
        }

        $query = static::where($this->getMatriculeAttributeName(), '=', $matricule)->first();

        // Check if the model is being updated (existing) or created (new).
        if ($this->exists && !$this->isDirty($this->matriculeAttribute)) {
            $query->whereKeyNot($this->getKey());
        }

        if ($query) {
            // The matricule is not unique, generate a new one with an incremented suffix.
            $suffix++;
            return $this->makeUniqueMatricule($matricule, $suffix);
        }

        return $matricule;
    }
}