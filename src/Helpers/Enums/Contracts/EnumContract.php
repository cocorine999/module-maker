<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts;


/**
 * Interface ***`EnumContract`***
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Enums\Contracts`***
 */
interface EnumContract
{
    /**
     * Get all the available enum values as an associative array.
     *
     * @return array An associative array where the keys are the enum values and the values are their corresponding labels.
     */
    public static function all(): array;

    /**
     * Get all the available enum values as an array.
     *
     * @return array An array containing all the available enum values.
     */
    public static function values(): array;

    /**
     * Get all the enum labels as an array.
     *
     * @return array An array containing all the labels for the enum values.
     */
    public static function labels(): array;

    /**
     * Get the keys (constants) of the enum.
     *
     * @return array An array containing the keys (constants) of the enum.
     */
    public static function keys(): array;

    /**
     * Get the enum instance based on the provided key (constant).
     *
     * @param string $key The key (constant) to search for.
     * @return static|null The enum instance corresponding to the provided key, or null if not found.
     */
    public static function getInstanceForKey(string $key): ?static;

    /**
     * Get the default enum instance.
     *
     * @return static The default enum instance.
     */
    public static function defaultInstance(): static;

    /**
     * Get the fallback enum instance.
     *
     * @return static The fallback enum instance.
     */
    public static function fallbackInstance(): static;

    /**
     * Get the enum values as key-value pairs (associative array).
     *
     * @return array An associative array containing the enum values as keys and their corresponding labels as values.
     */
    public static function keyValuePairs(): array;

    /**
     * Get all the enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array;

    /**
     * Check if the provided enum instance equals the given enum instance.
     *
     * @param static $instance The enum instance to compare with.
     * @param static $other The other enum instance to compare with.
     * @return bool True if the provided instance is equal to the other enum instance, false otherwise.
     */
    public static function equals($instance, $other): bool;

    /**
     * Check if the provided enum instance is within a given set of enum instances.
     *
     * @param static $instance The enum instance to check.
     * @param array $instances The set of enum instances to compare with.
     * @return bool True if the provided instance is within the set, false otherwise.
     */
    public static function inSet($instance, array $instances): bool;

    /**
     * Get the enum value for the given key (constant name).
     *
     * @param string $key The key (constant name) to retrieve the enum value for.
     * @return mixed|null The enum value for the given key, or null if not found.
     */
    public static function getValueForKey(string $key);

    /**
     * Check if the provided key (constant name) is a valid enum key.
     *
     * @param string $key The key to check.
     * @return bool True if the key is a valid enum key, false otherwise.
     */
    public static function isValidKey(string $key): bool;

    /**
     * Check if the provided enum instance matches the provided enum key.
     *
     * @param static $instance The enum instance to check.
     * @param string $key The enum key to compare against.
     * @return bool True if the provided enum instance matches the enum key, false otherwise.
     */
    public static function isMatchingKey($instance, string $key): bool;

    /**
     * Get all the available enum values as an array.
     *
     * @return array
     */
    public static function toArray(): array;


    /**
     * Check if the provided value is a valid enum value.
     *
     * @param mixed $value The value to check.
     * @return bool True if the value is a valid enum value, false otherwise.
     */
    public static function isValid($value): bool;

    /**
     * Get the enum constant based on the provided value.
     *
     * @param string $value The value to search for.
     * @return self|null The enum constant corresponding to the provided value, or null if not found.
     */
    public static function fromValue(string $value): ?self;

    /**
     * Get the human-readable label for the enum constant.
     *
     * This method returns a human-readable label for the given enum value. If the provided value is null or invalid,
     * it returns the label for the default enum constant, if defined.
     *
     * @return string The human-readable label for the enum constant.
     */
    public function label(): string;

    /**
     * Get the description for the enum constant.
     *
     * This method is invoked on an enum instance and returns the description that describes the purpose or meaning of the current enum constant.
     * The description provides additional information about the enum constant.
     * If the enum constant is not found, it returns null.
     *
     * @return string|null The description for the enum constant, or null if not found.
     */
    public function description(): ?string;

    /**
     * Get the human-readable label for the enum constant with the provided value.
     *
     * @param string $value The value of the enum constant.
     * @return string The human-readable label for the enum constant.
     */
    public static function getLabel(string $value): string;

    /**
     * Get the description for the enum constant with the provided value.
     *
     * @param string $value The value of the enum constant.
     * @return string|null The description for the enum constant, or null if not found.
     */
    public static function getDescription(string $value): ?string;

    /**
     * Get the key-value pairs of enum labels and their corresponding values.
     *
     * @return array An associative array with enum labels as keys and their corresponding values.
     */
    public static function labelsWithValues(): array;

    /**
     * Check if the given value is a valid enum label.
     *
     * @param string $label The label to check.
     * @return bool True if the label is a valid enum label, false otherwise.
     */
    public static function isValidLabel(string $label): bool;

    /**
     * Get the enum value for the provided enum label.
     *
     * @param string $label The label to get the value for.
     * @return mixed|null The enum value for the provided label, or null if not found.
     */
    public static function getValueForLabel(string $label);
    
    /**
     * Get all the enum constants as an associative array, with the constant values as keys and labels as values.
     *
     * @return array An associative array with enum constant values as keys and their labels as values.
     */
    public static function asAssocArray(): array;

    /**
     * Get the next enum constant relative to the provided value.
     *
     * @param string $value The value of the current enum constant.
     * @param bool $loop Whether to loop back to the first constant if the provided value is the last one.
     * @return string|null The value of the next enum constant, or null if not found.
     */
    public static function getNext(string $value, bool $loop = false): ?string;

    /**
     * Get the previous enum constant relative to the provided value.
     *
     * @param string $value The value of the current enum constant.
     * @param bool $loop Whether to loop back to the last constant if the provided value is the first one.
     * @return string|null The value of the previous enum constant, or null if not found.
     */
    public static function getPrevious(string $value, bool $loop = false): ?string;

    /**
     * Resolve the appropriate title based on the enum constant.
     *
     * @return string The resolved title.
     */
    public function resolveEnum(): string;
    
    /**
     * Check if the enum has a fallback value defined.
     *
     * @return bool True if the enum has a fallback value, false otherwise.
     */
    public static function hasFallback(): bool;

    /**
     * Get the enum constant as an associative array where keys are the enum values and values are the corresponding labels.
     *
     * @return array The associative array of enum constants with values and labels.
     */
    public static function toAssociativeArray(): array;

    /**
     * Get the enum constant as an associative array where keys are the enum names (constant names) and values are the corresponding labels.
     *
     * @return array The associative array of enum constants with names (constant names) and labels.
     */
    public static function namesWithLabels(): array;

    /**
     * Get the human-readable label for the enum value name (constant name).
     *
     * @param string $name The name (constant name) of the enum value.
     * @return string|null The human-readable label for the enum value name, or null if not found.
     */
    public static function labelFromName(string $name): ?string;

    /**
     * Get a random enum constant.
     *
     * @return self The random enum constant.
     */
    public static function random(): self;

    /**
     * Check if the provided enum instance equals another enum instance.
     *
     * @param static $instance The enum instance to compare.
     * @param static $other The other enum instance to compare with.
     * @return bool True if the enum instances are equal, false otherwise.
     */
    public static function isEqual($instance, $other): bool;

    /**
     * Check if the provided enum instance is in a list of enum instances.
     *
     * @param static $instance The enum instance to check.
     * @param array $enumList An array of enum instances to check against.
     * @return bool True if the enum instance is in the list, false otherwise.
     */
    public static function isInList($instance, array $enumList): bool;

    /**
     * Check if the provided enum instance is in a list of enum values.
     *
     * @param static $instance The enum instance to check.
     * @param array $valueList An array of enum values to check against.
     * @return bool True if the enum instance is in the list, false otherwise.
     */
    public static function isValueInList($instance, array $valueList): bool;

    /**
     * Get all the enum instances that satisfy the given condition.
     *
     * @param callable $callback The callback function used to filter the enum instances.
     * @return array An array containing all the enum instances that satisfy the condition.
     */
    public static function filter(callable $callback): array;

    /**
     * Get all the enum descriptions as an array.
     *
     * @return array An array containing all the enum descriptions.
     */
    public static function allDescriptions(): array;

    /**
     * Get an array of enum instances that are not in a given list.
     *
     * @param array $enumList An array of enum instances to exclude from the result.
     * @return array An array of enum instances that are not in the given list.
     */
    public static function exclude(array $enumList): array;

    /**
     * Check if the provided enum instance equals the default enum instance.
     *
     * @param static $instance The enum instance to compare with the default.
     * @return bool True if the provided instance is the default enum instance, false otherwise.
     */
    public static function isDefault($instance): bool;

    /**
     * Check if the provided enum instance equals the fallback enum instance.
     *
     * @param static $instance The enum instance to compare with the fallback.
     * @return bool True if the provided instance is the fallback enum instance, false otherwise.
     */
    public static function isFallback($instance): bool;

    /**
     * Get the count of available enum constants.
     *
     * @return int The count of available enum constants.
     */
    public static function count(): int;

    /**
     * Get the key-value pairs of the enum constants.
     *
     * @return array The array of key-value pairs.
     */
    public static function getKeyValuePairs(): array;

    /**
     * Get the name of the enum class.
     *
     * @return string The name of the enum class.
     */
    public static function getEnumName(): string;

    /**
     * Get the label based on the provided value.
     *
     * @param string $value The value to retrieve the label for.
     * @return string|null The label corresponding to the value, or null if not found.
     */
    public static function getLabelByValue(string $value): ?string;

    /**
     * Get the default enum value.
     *
     * @return self The default enum constant.
     */
    public static function default(): self;

    /**
     * Get the fallback enum value.
     *
     * @return self The fallback enum constant.
     */
    public static function fallback(): self;

    /**
     * Get all the enum values (constants) as an associative array with value as key and label as value.
     *
     * @return array
     */
    public static function valueLabelMap(): array;

    /**
     * Get all the enum names (constant names) as an array.
     *
     * @return array
     */
    public static function names(): array;

    /**
     * Get all the enum labels as an array.
     *
     * @return array
     */
    public static function allLabels(): array;

    /**
     * Get all the available enum values as an array.
     *
     * @return array An array with the available enum values.
     */
    public static function getValues(): array;

    /**
     * Get all the names of the enum constants.
     *
     * @return array The array of names.
     */
    public static function getNames(): array;

    /**
     * Get the human-readable label for the default enum constant.
     *
     * @return string The human-readable label for the default enum constant.
     */
    public static function defaultLabel(): string;

    /**
     * Get the human-readable label for the fallback enum constant.
     *
     * @return string The human-readable label for the fallback enum constant.
     */
    public static function fallbackLabel(): string;

    /**
     * Get the default enum value.
     *
     * @return string The default enum value.
     */
    public static function getDefault(): string;

    /**
     * Get the fallback enum value.
     *
     * @return string The fallback enum value.
     */
    public static function getFallback(): string;

    /**
     * Get all the enum labels as an array.
     *
     * @return array An array with the enum values as keys and their corresponding labels as values.
     */
    public static function getLabels(): array;

    /**
     * Get all the enum descriptions as an array.
     *
     * @return array An array with the enum values as keys and their corresponding descriptions as values.
     */
    public static function getDescriptions(): array;

    /**
     * Get the human-readable label for the provided enum value.
     *
     * @param string $value The value to get the label for.
     * @return string|null The human-readable label for the provided enum value, or null if not found.
     */
    public static function getLabelForValue(string $value): ?string;

    /**
     * Check if the enum instance matches the provided value.
     *
     * @param string $value The value to compare with the current enum instance.
     * @return bool True if the enum instance matches the provided value, false otherwise.
     */
    public function is(string $value): bool;

    /**
     * Check if the provided value exists in the enum.
     *
     * @param mixed $value The value to check.
     * @return bool True if the value exists in the enum, false otherwise.
     */
    public static function exists($value): bool;

    /**
     * Check if the enum instance does not match the provided value.
     *
     * @param string $value The value to compare with the current enum instance.
     * @return bool True if the enum instance does not match the provided value, false otherwise.
     */
    public function isNot(string $value): bool;

    /**
     * Get all the enum values as an array.
     *
     * @return array An array with all the enum values.
     */
    public static function getAllValues(): array;

    /**
     * Get the enum instance based on the provided value.
     *
     * @param string $value The value to search for.
     * @return static|null The enum instance corresponding to the provided value, or null if not found.
     */
    public static function getInstance(string $value): ?static;

    /**
     * Get the enum name (constant name) for the provided value.
     *
     * @param string $value The value to search for.
     * @return string|null The name (constant name) of the enum for the provided value, or null if not found.
     */
    public static function getNameForValue(string $value): ?string;

    /**
     * Get the enum value for the provided name (constant name).
     *
     * @param string $name The name (constant name) to search for.
     * @return string|null The value of the enum for the provided name, or null if not found.
     */
    public static function getValueForName(string $name): ?string;

    /**
     * Get the enum value name (constant name) for the provided value.
     *
     * @param string $value The value of the enum.
     * @return string|null The name (constant name) of the enum value, or null if not found.
     */
    public static function getName(string $value): ?string;

    /**
     * Get the enum value for the current enum instance.
     *
     * @return string The value of the current enum instance.
     */
    public function getValue(): string;

    /**
     * Check if the given name (constant name) is a valid enum name.
     *
     * @param string $name The name (constant name) to check.
     * @return bool True if the name is a valid enum name, false otherwise.
     */
    public static function isValidName(string $name): bool;

    /**
     * Get the name of an enum constant by its value.
     *
     * @param mixed $value The value of the constant.
     * @return string|null The name of the constant, or null if not found.
     */
    public static function getNameByValue($value): ?string;

    /**
     * Get the value of an enum constant by its name.
     *
     * @param string $name The name of the constant.
     * @return mixed|null The value of the constant, or null if not found.
     */
    public static function getValueByName(string $name);

    /**
     * Get all the valid enum names (constant names) as an array.
     *
     * @return array An array with all the valid enum names (constant names).
     */
    public static function getAllNames(): array;

    /**
     * Get all the valid enum instances as an array.
     *
     * @return array An array with all the valid enum instances.
     */
    public static function getAllInstances(): array;

    /**
     * Get the human-readable label for the provided enum name (constant name).
     *
     * @param string $name The name (constant name) to get the label for.
     * @return string|null The human-readable label for the provided enum name, or null if not found.
     */
    public static function getLabelForName(string $name): ?string;

    /**
     * Get the description for the provided enum name (constant name).
     *
     * @param string $name The name (constant name) to get the description for.
     * @return string|null The description for the provided enum name, or null if not found.
     */
    public static function getDescriptionForName(string $name): ?string;

    /**
     * Get the description for the provided enum value.
     *
     * @param  mixed        $value  The value to get the description for.
     * @return string|null          The description for the provided enum value, or null if not found.
     */
    public static function getDescriptionForValue($value): ?string;

    /**
     * Get the keys (constants) of the enum as a comma-separated string.
     *
     * @return string The keys (constants) of the enum as a comma-separated string.
     */
    public static function keysAsString(): string;

    /**
     * Get the values of the enum as a comma-separated string.
     *
     * @return string The values of the enum as a comma-separated string.
     */
    public static function valuesAsString(): string;

    /**
     * Check if the provided enum instance is one of the specified keys (constants).
     *
     * @param static $instance The enum instance to check.
     * @param array|string $keys The keys (constants) to check against.
     * @return bool True if the enum instance matches any of the specified keys, false otherwise.
     */
    public static function isOneOf($instance, $keys): bool;

    /**
     * Get the enum instance based on the provided name (constant name).
     *
     * @param string $name The name (constant name) to search for.
     * @return static|null The enum instance corresponding to the provided name, or null if not found.
     */
    public static function getInstanceForName(string $name): ?static;

    /**
     * Get a random enum instance.
     *
     * @return static A random enum instance.
     */
    public static function getRandomInstance(): static;

    /**
     * Get the first enum instance that satisfies the given condition.
     *
     * @param callable $callback The callback function used to filter the enum instances.
     * @return static|null The first enum instance that satisfies the condition, or null if not found.
     */
    public static function find(callable $callback): ?static;

    /**
     * Check if the given value is a valid enum value.
     *
     * @param mixed $value The value to check.
     * @return bool True if the value is a valid enum value, false otherwise.
     */
    public static function isValidValue($value): bool;

    /**
     * Get the enum instance based on the provided value.
     *
     * @param mixed $value The value to search for.
     * @return static|null The enum instance corresponding to the provided value, or null if not found.
     */
    public static function getInstanceForValue($value): ?static;

    /**
     * Get all the available labels and their corresponding values as an array.
     *
     * @return array An array with labels as keys and their corresponding values as values.
     */
    public static function getLabelsAndValues(): array;

    /**
     * Get all the available descriptions and their corresponding values as an array.
     *
     * @return array An array with descriptions as keys and their corresponding values as values.
     */
    public static function getDescriptionsAndValues(): array;

    /**
     * Check if the provided enum instance matches the default enum value.
     *
     * @param static $instance The enum instance to check.
     * @return bool True if the provided enum instance is the default value, false otherwise.
     */
    public static function isDefaultInstance($instance): bool;

    /**
     * Check if the provided enum instance matches the fallback enum value.
     *
     * @param static $instance The enum instance to check.
     * @return bool True if the provided enum instance is the fallback value, false otherwise.
     */
    public static function isFallbackInstance($instance): bool;

    /**
     * Get the key (constant name) for the provided enum value.
     *
     * @param   mixed       $value  The value to get the key for.
     * @return  string|null         The key for the provided enum value, or null if not found.
     */
    public static function getKeyForValue($value): ?string;

    /**
     * Get all the available enum values as an associative array where the keys are the constants and the values are the labels.
     *
     * @return array An associative array containing the enum values and their labels.
     */
    public static function valuesWithLabels(): array;

    /**
     * Get all the available enum values as an associative array where the keys are the constants and the values are the descriptions.
     *
     * @return array An associative array containing the enum values and their descriptions.
     */
    public static function valuesWithDescriptions(): array;

    /**
     * Get the enum instance based on the provided label.
     *
     * @param string $label The label to search for.
     * @return static|null The enum instance corresponding to the provided label, or null if not found.
     */
    public static function fromLabel(string $label): ?static;

    /**
     * Get the enum instance based on the provided description.
     *
     * @param string $description The description to search for.
     * @return static|null The enum instance corresponding to the provided description, or null if not found.
     */
    public static function fromDescription(string $description): ?static;

    /**
     * Check if the provided key (constant) exists in the enum.
     *
     * @param string $key The key (constant) to check.
     * @return bool True if the key exists in the enum, false otherwise.
     */
    public static function hasKey(string $key): bool;

    /**
     * Check if the provided value exists in the enum.
     *
     * @param mixed $value The value to check.
     * @return bool True if the value exists in the enum, false otherwise.
     */
    public static function hasValue($value): bool;

    /**
     * Get the enum instance based on the provided key (constant) or value.
     *
     * This function checks both keys and values of the enum to find a match.
     *
     * @param string $keyOrValue The key (constant) or value to search for.
     * @return static|null The enum instance corresponding to the provided key or value, or null if not found.
     */
    public static function fromKeyOrValue(string $keyOrValue): ?static;

    /**
     * Get the key (constant) of the provided enum instance.
     *
     * @param static $instance The enum instance.
     * @return string|null The key (constant) of the enum instance, or null if not found.
     */
    public static function getKey($instance): ?string;

    /**
     * Get all the keys (names) of the enum constants.
     *
     * @return array The array of keys (names).
     */
    public static function getKeys(): array;

    /**
     * Get a random value from the enum.
     *
     * @return static The random value.
     */
    public static function getRandomValue(): static;

    /**
     * Get the label for the provided key (constant).
     *
     * @param string $key The key (constant) to get the label for.
     * @return string|null The label for the provided key, or null if not found.
     */
    public static function getLabelForKey(string $key): ?string;

    /**
     * Get the description for the provided key (constant).
     *
     * @param string $key The key (constant) to get the description for.
     * @return string|null The description for the provided key, or null if not found.
     */
    public static function getDescriptionForKey(string $key): ?string;

    /**
     * Get the human-readable label for the enum instance based on the provided key (constant) or value.
     *
     * This function checks both keys and values of the enum to find a match.
     *
     * @param string $keyOrValue The key (constant) or value to search for.
     * @return string|null The human-readable label for the enum instance, or null if not found.
     */
    public static function getLabelForKeyOrValue(string $keyOrValue): ?string;

    /**
     * Get the description for the enum instance based on the provided key (constant) or value.
     *
     * This function checks both keys and values of the enum to find a match.
     *
     * @param string $keyOrValue The key (constant) or value to search for.
     * @return string|null The description for the enum instance, or null if not found.
     */
    public static function getDescriptionForKeyOrValue(string $keyOrValue): ?string;

    /**
     * Check if the enum instance matches any of the provided values.
     *
     * @param mixed ...$values The values to check against.
     * @return bool True if the enum instance matches any of the provided values, false otherwise.
     */
    public function in(...$values): bool;

    /**
     * Get the value of the enum instance as a string.
     *
     * @return string The value of the enum instance as a string.
     */
    public function toString(): string;

}