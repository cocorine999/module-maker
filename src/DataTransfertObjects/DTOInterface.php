<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\DataTransfertObjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


/**
 * *`Interface DTOInterface`*
 *
 * This interface defines the contract for a `Data Transfer Object` (DTO).
 * `Data Transfert Objects` are used to encapsulate and transfer data between different layers of an application.
 *
 * @package \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects
 */
interface DTOInterface
{

    /**
     * Set the value of a specific property in the DTO.
     *
     * @param  string $propertyName The name of the property.
     * @param  mixed  $value        The value to be set.
     * @return void
     */
    public function setProperty(string $propertyName, $value): void;

    /**
     * Get the value of a specific property in the DTO.
     *
     * @param  string     $propertyName The name of the property.
     * @return mixed|null               The value of the property, or null if it doesn't exist.
     */
    public function getProperty(string $propertyName);

    /**
     * Check if a specific property exists in the DTO.
     *
     * @param  string $propertyName The name of the property.
     * @return bool                 True if the property exists, false otherwise.
     */
    public function hasProperty(string $propertyName): bool;

    /**
     * Remove a specific property from the DTO.
     *
     * @param  string $propertyName The name of the property to remove.
     * @return void
     */
    public function removeProperty(string $propertyName): void;

    /**
     * Get all properties and their values in the DTO.
     *
     * @return array An associative array containing all the properties and their values.
     */
    public function getProperties(): array;

    /**
     * Get the names of all properties in the DTO.
     *
     * @return array An array containing the names of all properties.
     */
    public function getPropertyNames(): array;

    /**
     * Set the value to be ignored for unique validation.
     *
     * @param string|array $key The key or keys to set the ignore value.
     * @param mixed $value The value to be ignored.
     * @return void
     */
    public function setIgnoreValue($key, $value): void;

    /**
     * Get the ignore values for unique validation.
     *
     * @return array The ignore values.
     */
    public function getIgnoreValues(): array;

    /**
     * Check if the current DTO is equal to another DTO.
     *
     * @param  \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $otherDTO The other DTO to compare with.
     * @return bool True if the DTO are equal, false otherwise.
     */
    public function isEqual(DTOInterface $otherDTO): bool;

    /**
     * Merge the properties of another DTO object into the current DTO object.
     *
     * @param  \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $dto The DTO to merge.
     * @return void
     */
    public function merge(DTOInterface $dto): void;

    /**
     * Merge an associative array of properties into the current DTO object.
     *
     * @param  array $data The associative array of properties.
     * @return void
     */
    public function mergeArray(array $data): void;

    /**
     * Clear all properties in the DTO.
     *
     * @return void
     */
    public function clearProperties(): void;

    /**
     * Check if the current DTO is equal to another DTO.
     *
     * @param  \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $other The other DTO to compare with.
     * @return bool                                           True if the DTO are equal, false otherwise.
     */
    public function equals(DTOInterface $other): bool;

    /**
     * Clear all properties of the DTO object.
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Clone the DTO and return a new instance.
     *
     * @return self A new instance of the DTO.
     */
    public function clone(): self;


    /**
     * Create a new instance of the DTO based on a request object.
     *
     * @param  Request $request The request object to populate the DTO from.
     * @return self             The new instance of the DTO.
     */
    public static function fromRequest(Request $request): self;

    /**
     * Convert the DTO to a request object.
     *
     * @return Request The converted request object.
     */
    public function toRequest(): Request;

    /**
     * Create a new instance of the DTO based on a model object.
     *
     * @param  Model $model The model object to populate the DTO from.
     * @return self         The new instance of the DTO.
     */
    public static function fromModel(Model $model): self;

    /**
     * Convert the DTO to a model object.
     *
     * @return Model The converted model object.
     */
    public function toModel(): Model;

    /**
     * Convert the DTO to an associative array.
     *
     * @return array The DTO represented as an associative array.
     */
    public function toArray(): array;

    /**
     * Create a new instance of the DTO based on an associative array.
     *
     * @param  array $data The associative array to populate the DTO from.
     * @return self The new instance of the DTO.
     */
    public static function fromArray(array $data): self;

    /**
     * Convert the DTO to a JSON string.
     *
     * @return string The DTO represented as a JSON string.
     */
    public function toJson(): string;

    /**
     * Create a new instance of the DTO based on a JSON string.
     *
     * @param  string $json The JSON string to populate the DTO from.
     * @return self         The new instance of the DTO.
     */
    public static function fromJson(string $json): self;

    /**
     * Convert the DTO to an XML string.
     *
     * @return string The DTO represented as an XML string.
     */
    public function toXml(): string;

    /**
     * Create a new instance of the DTO based on an XML string.
     *
     * @param string $xml The XML string to populate the DTO from.
     * @return self The new instance of the DTO.
     */
    public static function fromXml(string $xml): self;


    /**
     * Validate the DTO object.
     *
     * @return bool True if the DTO is valid, false otherwise.
     */
    public function validate(): bool;

    /**
     * Check if the DTO has any validation errors.
     *
     * @return bool True if the DTO has errors, false otherwise.
     */
    public function hasErrors(): bool;

    /**
     * Get the validation errors of the DTO.
     *
     * @return array An array containing the validation errors.
     */
    public function getErrors(): array;

    /**
     * Clear the validation errors of the DTO.
     *
     * @return void
     */
    public function clearErrors(): void;

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array An array containing the validation rules.
     */
    public function getValidationRules(): array;

    /**
     * Get the validation error messages for the DTO object.
     *
     * @return array An array containing the validation error messages.
     */
    public function getValidationMessages(): array;

    /**
     * Get a string representation of the DTO object.
     *
     * @return string The string representation of the DTO object.
     */
    public function __toString(): string;
}
