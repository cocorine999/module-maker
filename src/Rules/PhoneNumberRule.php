<?php

declare(strict_types = 1);

namespace LaravelCoreModule\CoreModuleMaker\Rules;

use LaravelCoreModule\CoreModuleMaker\Eloquents\ValueObjects\PhoneNumber;
use LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException;
use Illuminate\Contracts\Validation\Rule;


/**
 * Class `PhoneNumberRule`
 *
 * The PhoneNumberRule rule checks if a given value exists for the authenticated user and is a valid UUID.
 *
 * @package \LaravelCoreModule\CoreModuleMaker\Rules
 */
class PhoneNumberRule implements Rule
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
        try {
            if(is_string($value) && PhoneNumber::fromString($value))
            {

                return true;

            }
            elseif(new PhoneNumber($value)){
                return true;
            }
            return false;
        } catch (InvalidArgumentException $exception) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string The validation error message.
     */
    public function message()
    {
        return 'The :attribute must be a valid phone number.';
    }
}
