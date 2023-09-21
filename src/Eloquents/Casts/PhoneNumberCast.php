<?php

declare(strict_types = 1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\Casts;

use LaravelCoreModule\CoreModuleMaker\Eloquents\ValueObjects\PhoneNumber;
use LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * **`PhoneNumberCast`** : CastsAttributes implementation for casting phone numbers to and from the database.
 * The `PhoneNumberCast` class is a custom Eloquent cast for handling phone number attributes in Eloquent models.
 *
 * This class allows you to seamlessly store and retrieve phone number values as JSON strings in your database,
 * while working with them as `PhoneNumber` value objects within your Laravel application. The PhoneNumberCast
 * implements the `CastsAttributes` contract, providing two methods for casting attributes:
 * - The `get` method retrieves the phone number value from the database and returns it as a `PhoneNumber` object.
 * - The `set` method prepares the phone number value for storage in the database by converting it to a JSON string.
 *
 * Usage:
 * To use this cast, first, ensure you have the `PhoneNumber` value object and the corresponding cast class set up.
 * Then, define the attribute in your Eloquent model with the `cast` property set to `PhoneNumberCast::class`.
 * This will enable automatic conversion to and from JSON when interacting with the attribute.
 *
 * Example:
 * ```
 * namespace App\Models;
 *
 * use Illuminate\Database\Eloquent\Model;
 * use LaravelCoreModule\CoreModuleMaker\Eloquents\Casts\PhoneNumberCast;
 *
 * class User extends Model
 * {
 *     protected $casts = [
 *         'phone_number' => PhoneNumberCast::class,
 *     ];
 * }
 * ```
 *
 * @package LaravelCoreModule\CoreModuleMaker\Eloquents\Casts
 */
class PhoneNumberCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * This method is responsible for casting the stored value of the phone number attribute to a `PhoneNumber` object.
     * If the value is null, it returns null as well.
     *
     * @param  Model                $model      The Eloquent model instance.
     * @param  string               $key        The attribute key.
     * @param  mixed                $value      The stored value of the attribute.
     * @param  array<string, mixed> $attributes The array of all the model's attributes.
     * @return string                            The casted value as a `PhoneNumber` object or null.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        /*
         * We'll need this to handle nullable columns
         */
        if (is_null($value)) {
            return null;
        }

        // Attempt to create a PhoneNumber instance from the JSON-decoded value
        $phoneNumber = PhoneNumber::fromJson($value);

        // Check if the PhoneNumber instance was created successfully
        if (!($phoneNumber instanceof PhoneNumber)) {
            throw new \InvalidArgumentException('Failed to cast value to PhoneNumber object');
        }

        // Return the PhoneNumber instance
        return $phoneNumber->toString();
    }


    /**
     * Prepare the given value for storage.
     *
     * This method is responsible for preparing the value of the phone number attribute for storage.
     * If the value is null, it returns null as well.
     * If the value is an array, it creates a new `PhoneNumber` object from the array.
     * If the value is a string, it creates a new `PhoneNumber` object using the `fromString` method.
     * If the value is not an instance of `PhoneNumber`, it throws an `InvalidArgumentException`.
     * Finally, it converts the `PhoneNumber` object to its JSON representation and returns it.
     *
     * @param  Model                $model      The Eloquent model instance.
     * @param  string               $key        The attribute key.
     * @param  mixed                $value      The value to be stored.
     * @param  array<string, mixed> $attributes The array of all the model's attributes.
     * @return mixed                            The prepared value as a JSON representation of the `PhoneNumber` object or null.
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException If the value is not of type `PhoneNumber`, array, or null.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        
        /*
         * We'll need this to handle nullable columns
         */
        if (is_null($value)) {
            return null;
        }

        /*
         * Allow the user to pass an array instead of the value object itself.
         * Similar to how we can pass a date string or a Carbon/DateTime object with a date cast.
         */
        if (is_array($value)) {
            $value = new PhoneNumber($value);
        }
        elseif (is_string($value)) {
            // Attempt to encode the string as JSON
            $decodedValue = json_decode($value, true);

            // Check if the JSON encoding was successful
            if ($decodedValue !== null) {
                // If successful, convert the JSON-encoded value to the desired format
                $value = PhoneNumber::fromJson($value);
            } else {
                $value = PhoneNumber::fromString($value);
            }
        } elseif (! $value instanceof PhoneNumber) {
            throw new InvalidArgumentException('Value must be of type PhoneNumber, array, or null');
        }

        // Convert the PhoneNumber to its JSON representation
        return $value->toJson();

    }
}
