<?php

declare(strict_types = 1);

namespace LaravelCoreModule\CoreModuleMaker\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;


/**
 * Class `ExistsForAuthUserAndUUID`
 *
 * The ExistsForAuthUserAndUUID rule checks if a given value exists for the authenticated user and is a valid UUID.
 *
 * @package \LaravelCoreModule\CoreModuleMaker\Rules
 */
class ExistsForAuthUserAndUUID implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute The attribute being validated.
     * @param  mixed   $value     The value being validated.
     * @return bool               True if the validation passes, false otherwise.
     */
    public function passes($attribute, $value)
    {
        return User::where('id', $value)
            ->where('created_by', auth()->id())
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string The validation error message.
     */
    public function message()
    {
        return 'The selected :attribute does not exist for the authenticated user.';
    }

    /**
     * Validate that the given value is a valid UUID.
     *
     * @param  string  $value The value being validated.
     * @return bool           True if the value is a valid UUID, false otherwise.
     */
    protected function isValidUUID($value)
    {
        return is_string($value) && Str::isUuid($value);
    }
}
