<?php

declare(strict_types = 1);

namespace LaravelCoreModule\CoreModuleMaker\Rules;

use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\File;

/**
 * Class `ValidMorphType`
 *
 * The ValidMorphType rule checks if a given value exists for the authenticated user and is a valid UUID.
 *
 * @package \LaravelCoreModule\CoreModuleMaker\Rules
 */
class ValidMorphType implements Rule
{
    protected $allowedTypes;

    public function __construct(array $allowedTypes = [])
    {
        $this->allowedTypes = $allowedTypes;
    }
    
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute The attribute being validated.
     * @param  mixed   $value     The value being validated.
     * @return bool               True if the validation passes, false otherwise.
     */
    public function passes($attribute, $value)
    {

        if(!Schema::hasTable($value)) return false;

        if(empty($this->allowedTypes)) $this->allowedTypes = loadTables();

        // Check if the $value is in the list of allowed morph types
        return in_array($value, $this->allowedTypes);

    }

    /**
     * Get the validation error message.
     *
     * @return string The validation error message.
     */
    public function message()
    {
        return 'The :attribute is not a valid morph type.';
    }

}
