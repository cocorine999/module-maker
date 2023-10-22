<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Eloquents\ValueObjects;

use LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException;
use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\TypeOfStreetEnum;

/**
 * **`Class Street`**: The Street class represents a phone number value object.
 *
 * The `Street` class represents a `phone number` as a value object.
 * It encapsulates the `country code`, `area code`, and `phone number` itself.
 *
 * Usage:
 * To create a `Street` object, pass an array with the keys 'country_code',
 * 'area_code', and 'number' to the constructor. The associated values
 * should be strings.
 *
 * Example:
 * ```
 * $phoneNumber = new Street([
 *     'country_code' => '1',
 *     'area_code' => '123',
 *     'number' => '4567890',
 * ]);
 * ```
 *
 * The `Street` class provides various methods for working with phone numbers,
 * such as retrieving the `country code`, `area code`, and `phone number`, validating
 * the street's format, and converting the object to a string or an array.
 *
 * @package Core\Eloquents\ValueObjects
 */
class Street
{
    /**
     * The name of the street.
     *
     * @var string
     */
    private string $street_name;

    /**
     * The type of the street.
     *
     * @var TypeOfStreetEnum
     */
    private TypeOfStreetEnum $street_type;

    /**
     * The street_number.
     *
     * @var string
     */
    private string $street_number;
    
    /**
     * Create a new instance of Street.
     *
     * @param array $attributes The attributes of the phone number.
     *                          The array should contain the keys 'country_code', 'area_code', and 'number'.
     *                          The associated values should be strings.
     */
    public function __construct(array $attributes = [])
    {
        $this->validate($attributes);

    }

    public function getStreetName(): string
    {
        return $this->street_name;
    }

    public function getStreetType(): TypeOfStreetEnum
    {
        return $this->street_type;
    }

    public function getStreetNumber(): string
    {
        return $this->street_number;
    }

    public function setStreetName(string $street_name): void
    {
        $this->street_name = $street_name;
    }

    public function setStreetType(TypeOfStreetEnum $street_type): void
    {
        $this->street_type = $street_type;
    }

    public function setStreetNumber(string $street_number): void
    {
        $this->street_number = $street_number;
    }

    /**
     * Get the properties of the DTO.
     *
     * @return array The DTO properties.
     */
    protected function getProperties(): array
    {
        return get_object_vars($this);
    }

    /**
     * Convert the Street object to a string representation.
     *
     * This method formats the phone number as a string, including the country code,
     * area code, and subscriber number.
     *
     * @return string The formatted phone number string.
     */
    public function toString()
    {
        return $this->street_number . ' ' . $this->street_name . ' ' . $this->street_type;
    }

    /**
     * Convert the Street object to a string representation.
     *
     * This method formats the phone number as a string, including the country code,
     * area code, and subscriber number.
     *
     * @return string The formatted phone number string.
     */
    public function __toString()
    {

        return $this->street_number . ' ' . $this->street_name . ' ' . $this->street_type;
    }

    /**
     * Convert the Street object to a JSON representation.
     *
     * This method converts the Street object to a JSON string representation.
     *
     * @return string The JSON representation of the Street object.
     */
    public function toJson(): string
    {
        // Format the phone number as needed
        return json_encode($this->toArray());
    }

    /**
    * Create a Street object from a JSON representation.
    *
    * This static method creates a Street object from a string representation
    * of a phone number. It performs normalization on the provided phone number
    * by removing non-digit characters and extracting the country code, area code,
    * and remaining digits. The resulting Street object is returned.
    *
    * @param  string $json The JSON representation of the phone number.
    * @return self         The Street object created from the JSON representation.

    * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException If the JSON is invalid or does not represent a valid phone number.
    */
    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);

        if ($data === null || json_last_error() !== JSON_ERROR_NONE) {
            throw new \LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException('Invalid JSON provided.');
        }

        return new self($data);
    }

    /**
     * Convert the Street object to an array representation.
     *
     * This method converts the Street object to an array representation,
     * including the country code, area code, and phone number.
     *
     * @return array The array representation of the Street object.
     */
    public function toArray(): array
    {
        // Format telephone number as needed
        return [
            'street_name' => $this->street_name,
            'street_type' => $this->street_type,
            'street_number' => $this->street_number,

        ];
    }

    /**
     * Validate the attributes of the Street object.
     * This method performs validation on the provided data to ensure that all required keys are present and match the expected properties of the Street object. If validation fails, a ValidationException is thrown.
     *
     * @param array $attributes The data to validate.
     * @return bool
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validate(array $attributes): bool
    {
        if (isset($attributes['street_name']) && is_string($attributes['street_name'])) {
            $this->street_name = $attributes['street_name'];
        } else {
            throw new InvalidArgumentException("Invalid street name.");
        }
    
        if (isset($attributes['street_type']) && $attributes['street_type'] instanceof TypeOfStreetEnum) {
            $this->street_type = $attributes['street_type'];
        } else {
            throw new InvalidArgumentException("Invalid street type.");
        }
    
        if (isset($attributes['street_number']) && is_string($attributes['street_number'])) {
            $this->street_number = $attributes['street_number'];
        } else {
            throw new InvalidArgumentException("Invalid street number.");
        }

        return true;
    }

    /**
     * Create a Street object from a string representation.
     *
     * This static method creates a Street object from a string representation
     * of a phone number. It performs normalization on the provided phone number
     * by removing non-digit characters and extracting the country code, area code,
     * and remaining digits. The resulting Street object is returned.
     *
     * @param  string $number            The string representation of the phone number.
     * @return self                      The Street object.
     *
     * @throws \InvalidArgumentException If an invalid phone number string is provided.
     */
    public static function fromString(string $street): self
    {

        // Split the input string into its components
        $components = explode(' ', $street);

        // Assuming the input string follows the format "StreetName StreetType StreetNumber"
        if (count($components) >= 3) {
            $streetName = $components[0];
            $streetType = $components[1];
            $streetNumber = $components[2];

            return new self([
                'street_name' => $streetName,
                'street_type' => TypeOfStreetEnum::getValueForLabel($streetType), // Assuming TypeOfStreetEnum has a fromString method
                'street_number' => $streetNumber,
            ]);
        } else {
            // Handle the case when the input string format is incorrect
            throw new InvalidArgumentException('Invalid street format.');
        }
        return new self([
            
        ]);
    }

    /**
     * Check if a value is not empty.
     *
     * This function checks if the given value is not empty. If the value is empty,
     * it returns false; otherwise, it returns true.
     *
     * @param string $value The value to check.
     * @param string $message The error message to include in the exception.
     * @return bool Returns true if the value is not empty, false otherwise.
     */
    protected static function isNotEmpty(string $value, string $message): bool
    {
        if (empty($value)) {
            throw new \Exception($message);
        }
        return true;
    }

}