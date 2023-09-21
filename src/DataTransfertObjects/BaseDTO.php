<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\DataTransfertObjects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;


/**
 * Class BaseDTO
 *
 * This abstract class provides a base implementation of the DTOInterface.
 * Custom DTO classes can extend this class to inherit common functionality.
 *
 * @package \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects
 */
class BaseDTO implements DTOInterface
{

    protected $ignoreValues = [];

    /**
     * @var array An associative array to store the DTO properties and their values.
     */
    protected $properties = [];

    /**
     * @var array An associative array to store the DTO properties validation errors.
     */
    protected $errors = [];

    /**
     * @var array The validation rules for the DTO.
     */
    protected $rules = [];

    /**
     * @var array The validation error messages for the DTO.
     */
    protected $messages = [];

    /**
     * Construct a new DTO instance.
     *
     * @param array $data The initial data to populate the DTO properties.
     */
    public function __construct(array $data = [])
    {
        $this->mergeArray($data);
        $this->getProperties();
        $this->messages();
    }

    /**
     * Set the value of a specific property in the DTO.
     *
     * @param  string $propertyName The name of the property.
     * @param  mixed  $value        The value to be set.
     * @return void
     */
    public function setProperty(string $propertyName, $value): void
    {
        $this->properties[$propertyName] = $value;
    }

    /**
     * Get the value of a specific property in the DTO.
     *
     * @param  string     $propertyName The name of the property.
     * @return mixed|null               The value of the property, or null if it doesn't exist.
     */
    public function getProperty(string $propertyName)
    {
        return isset($this->properties[$propertyName]) ? $this->properties[$propertyName] : null;
    }

    /**
     * Check if a specific property exists in the DTO.
     *
     * @param  string $propertyName The name of the property.
     * @return bool                 True if the property exists, false otherwise.
     */
    public function hasProperty(string $propertyName): bool
    {
        return isset($this->properties[$propertyName]);
    }

    /**
     * Remove a specific property from the DTO.
     *
     * @param  string $propertyName The name of the property to remove.
     * @return void
     */
    public function removeProperty(string $propertyName): void
    {
        if ($this->hasProperty($this->properties[$propertyName])) {
            unset($this->properties[$propertyName]);
        }
    }

    /**
     * Get all properties and their values in the DTO.
     *
     * @return array An associative array containing all the properties and their values.
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Get the names of all properties in the DTO.
     *
     * @return array An array containing the names of all properties.
     */
    public function getPropertyNames(): array
    {
        return array_keys($this->properties);
    }

    /**
     * Set the value to be ignored for unique validation.
     *
     * @param string|array $key   The key or keys to set the ignore value.
     * @param mixed        $value The value to be ignored.
     * @return void
     */
    public function setIgnoreValue($key, $value): void
    {
        $this->ignoreValues = Arr::set($this->ignoreValues, $key, $value);
    }

    /**
     * Get the ignore values for unique validation.
     *
     * @return array The ignore values.
     */
    public function getIgnoreValues(): array
    {
        return $this->ignoreValues;
    }

    /**
     * Check if the current DTO is equal to another DTO.
     *
     * @param  \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $otherDTO The other DTO to compare with.
     * @return bool                   True if the DTO are equal, false otherwise.
     */
    public function isEqual(DTOInterface $otherDTO): bool
    {
        return $this->toArray() === $otherDTO->toArray();
    }

    /**
     * Merge the properties of another DTO object into the current DTO object.
     *
     * @param  \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $dto The DTO to merge.
     * @return void
     */
    public function merge(DTOInterface $dto, string $key = null, array $key_rules = []): void
    {
        $this->properties = array_merge($this->properties, $dto->getProperties());
        $rules = $key ? ["$key" => $dto->getValidationRules()] : $dto->getValidationRules();
        $messages = $key ? ["$key" => $dto->getValidationMessages()] : $dto->getValidationMessages();
        $this->rules($rules);
        $this->messages($messages);
    }

    /**
     * Merge an associative array of properties into the current DTO object.
     *
     * @param  array $data The associative array of properties.
     * @return void
     */
    public function mergeArray(array $data): void
    {
        foreach ($data as $propertyName => $value) {
            $this->setProperty($propertyName, $value);
        }
    }

    /**
     * Clear all properties in the DTO.
     *
     * @return void
     */
    public function clearProperties(): void
    {
        $this->properties = [];
    }

    /**
     * Check if the current DTO is equal to another DTO.
     *
     * @param  \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects\DTOInterface $other The other DTO to compare with.
     * @return bool                                           True if the DataTransfertObjects are equal, false otherwise.
     */
    public function equals(DTOInterface $other): bool
    {
        return $this->isEqual($other);
    }

    /**
     * Clear all properties of the DTO object.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->clearProperties();
        $this->clearErrors();
    }

    /**
     * Clone the DTO and return a new instance.
     *
     * @return self A new instance of the DTO.
     */
    public function clone(): self
    {
        return clone $this;
    }


    /**
     * Create a new instance of the DTO based on a request object.
     *
     * @param  Request $request The request object to populate the DTO from.
     * @return self             The new instance of the DTO.
     */
    public static function fromRequest(Request $request): self
    {
        $dto = new static();
        $dto->mergeArray($request->all());
        return $dto;
    }

    /**
     * Convert the DTO to a request object.
     *
     * @return Request The converted request object.
     */
    public function toRequest(): Request
    {
        // Implement logic to convert DTO to request object
        $request = new Request($this->getProperties());
        return $request;
    }

    /**
     * Create a new instance of the DTO based on a model object.
     *
     * @param  Model $model The model object to populate the DTO from.
     * @return self         The new instance of the DTO.
     */
    public static function fromModel(Model $model): self
    {
        $dto = new static();

        foreach ($dto->getPropertyNames() as $propertyName) {
            if (property_exists($model, $propertyName)) {
                $dto->setProperty($propertyName, $model->$propertyName);
            }
        }

        return $dto;
    }

    /**
     * Convert the DTO to a model object.
     *
     * @return Model The converted model object.
     */
    public function toModel(): Model
    {
        $modelClass = $this->getModelClass();
        $model = new $modelClass;

        foreach ($this->getProperties() as $propertyName => $value) {
            if (property_exists($model, $propertyName)) {
                $model->$propertyName = $value;
            }
        }

        return $model;
    }

    /**
     * Convert the DTO to an associative array.
     *
     * @return array The DTO represented as an associative array.
     */
    public function toArray(): array
    {
        return $this->getProperties();
    }

    /**
     * Create a new instance of the DTO based on an associative array.
     *
     * @param  array $data The associative array to populate the DTO from.
     * @return self The new instance of the DTO.
     */
    public static function fromArray(array $data): self
    {
        $dto = new static();
        $dto->mergeArray($data);
        return $dto;
    }

    /**
     * Convert the DTO to a JSON string.
     *
     * @return string The DTO represented as a JSON string.
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Create a new instance of the DTO based on a JSON string.
     *
     * @param  string $json The JSON string to populate the DTO from.
     * @return self         The new instance of the DTO.
     */
    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);
        $dto = new static();
        $dto->mergeArray($data);
        return $dto;
    }

    /**
     * Convert the DTO to an XML string.
     *
     * @return string The DTO represented as an XML string.
     */
    public function toXml(): string
    {
        return '';
    }

    /**
     * Create a new instance of the DTO based on an XML string.
     *
     * @param string $xml The XML string to populate the DTO from.
     * @return self The new instance of the DTO.
     */
    public static function fromXml(string $xml): self
    {
        return $dto = new static();
    }

    /**
     * Validate the DTO object.
     *
     * @return bool True if the DTO is valid, false otherwise.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(): bool
    {
        $validator = Validator::make($this->getProperties(), $this->getValidationRules(), $this->getValidationMessages());

        $this->errors = [];

        if ($validator->fails()) {
            $this->errors = $validator->errors()->toArray();
            throw new ValidationException($validator, 422);

            return false;
        }

        return true;
    }

    /**
     * Check if the DTO has any validation errors.
     *
     * @return bool True if the DTO has errors, false otherwise.
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Get the validation errors of the DTO.
     *
     * @return array An array containing the validation errors.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Clear the validation errors of the DTO.
     *
     * @return void
     */
    public function clearErrors(): void
    {
        $this->errors = [];
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array An array containing the validation rules.
     */
    public function getValidationRules(): array
    {
        return $this->rules();
    }

    /**
     * Get the validation error messages for the DTO object.
     *
     * @return array An array containing the validation error messages.
     */
    public function getValidationMessages(): array
    {
        return $this->messages();
    }

    /**
     * Get a string representation of the DTO object.
     *
     * @return string The string representation of the DTO object.
     */
    public function __toString(): string
    {
        return static::class;
    }

    /**
     * Get the class name of the model associated with the DTO.
     *
     * @return string The class name of the model.
     */
    protected function getModelClass(): string
    {
        return "User";
    }

    /**
     * Get the validation rules for the DTO object.
     *
     * @return array The validation rules.
     */
    public function rules(array $rules = []): array
    {
        return $this->rules = array_merge($this->rules, $rules);
    }

    /**
     * Get the validation error messages for the DTO object.
     *
     * @return array The validation error messages.
     */
    public function messages(array $messages = []): array
    {
        return $this->messages = array_merge($this->messages, $messages);
    }
}
