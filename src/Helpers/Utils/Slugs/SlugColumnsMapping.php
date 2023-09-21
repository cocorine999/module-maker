<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable;

use LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException;


/**
 * Class SlugColumnsMapping
 *
 * The `SlugColumnsMapping` class defines a mapping between model attributes and their corresponding
 * database columns that will be used to generate a slug.
 *
 * @package LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Sluggable
 */
class SlugColumnsMapping
{
    /**
     * The attribute name that will be used to store the generated slug.
     *
     * @var string
     */
    protected $slugAttribute;

    /**
     * The database column(s) that will be used to generate the slug.
     * This can be a string for a single column or an array of column names
     * if the slug needs to be generated based on multiple columns.
     *
     * @var string|string[]
     */
    protected $sourceColumns;

    /**
     * The separator character to use in the generated slug. Default is '-'.
     *
     * @var string
     */
    protected $separator = '-';

    /**
     * The fallback attribute to use when the source columns are empty for slug generation.
     * This attribute will be used to generate the fallback slug.
     *
     * @var string|null
     */
    protected $fallbackAttribute = 'name';

    /**
     * Constructor for the SlugColumnsMapping class.
     *
     * @param string $slugAttribute The attribute name to store the generated slug.
     * @param string|string[] $sourceColumns The database column(s) for slug generation.
     * @param string $separator The separator character for the slug. Default is '-'.
     * @param string $fallbackAttribute The fallback attribute to use when source columns are empty. Default is 'name'.
     */
    public function __construct(string $slugAttribute, $sourceColumns, string $separator = '-', ?string $fallbackAttribute = 'name')
    {
        dd("Construct");
        $this->slugAttribute = $slugAttribute;
        $this->sourceColumns = $sourceColumns;
        $this->fallbackAttribute = $fallbackAttribute;
        $this->separator = $separator;
    }

    /**
     * Get the attribute name that will be used to store the generated slug.
     *
     * @return string
     */
    public function getSlugAttribute(): string
    {
        return $this->slugAttribute;
    }

    /**
     * Get the database column(s) that will be used to generate the slug.
     *
     * @return string|string[]
     */
    public function getSourceColumns()
    {
        return $this->sourceColumns;
    }

    /**
     * Get the separator character to use in the generated slug.
     *
     * @return string
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }

    /**
     * Set the separator character to use in the generated slug.
     *
     * @param string $separator The separator character for the slug.
     * @return void
     */
    public function setSeparator(string $separator): void
    {
        $this->separator = $separator;
    }

    /**
     * Generate the slug from the provided model instance based on the mapping configuration.
     *
     * @param object $model The model instance to generate the slug for.
     * @return string|null The generated slug or null if any of the source columns is empty.
     */
    public function generateSlug($modelOrAttributes): string
    {
        if (is_object($modelOrAttributes)) {
            return $this->generateSlugFromModel($modelOrAttributes);
        } elseif (is_array($modelOrAttributes)) {
            return $this->generateSlugFromArray($modelOrAttributes);
        }

        throw new InvalidArgumentException('Invalid argument type. Expected object or array.');
    }

    /**
     * Generate the slug from the provided model instance.
     *
     * @param object $model The model instance to generate the slug for.
     * @return string The generated slug.
     */
    public function generateSlugFromModel($model): string
    {
        $slugParts = [];
        if (is_array($this->sourceColumns)) {
            foreach ($this->sourceColumns as $column) {
                $value = $model->{$column};
                $slugParts[] = $this->slugify($value);
            }
        } else {
            $value = $model->{$this->sourceColumns};
            $slugParts[] = $this->slugify($value);
        }

        // Generate the fallback slug if no valid slug parts are found
        if (empty($slugParts)) {
            return $this->generateFallbackSlug($model);
        }

        return implode($this->separator, $slugParts);
    }

    /**
     * Generate the slug based on the provided model attributes.
     *
     * @param array $attributes The model's attributes (associative array).
     * @return string The generated slug.
     */
    public function generateSlugFromArray(array $attributes): string
    {
        $slugParts = [];
        if (is_array($this->sourceColumns)) {
            foreach ($this->sourceColumns as $column) {
                $value = $attributes[$column] ?? '';
                $slugParts[] = $this->slugify($value);
            }
        } else {
            $value = $attributes[$this->sourceColumns] ?? '';
            $slugParts[] = $this->slugify($value);
        }

        // Generate the fallback slug if no valid slug parts are found and fallback attribute is provided
        if (empty($slugParts) && $this->fallbackAttribute !== null) {
            return $this->generateFallbackSlug($attributes);
        }

        return implode($this->separator, $slugParts);
    }

    /**
     * Generate the fallback slug using the provided model or attributes.
     *
     * @param object|array $modelOrAttributes The model instance or an associative array of attributes to generate the fallback slug for.
     * @return string The generated fallback slug.
     */
    protected function generateFallbackSlug($modelOrAttributes): string
    {
        if (is_object($modelOrAttributes)) {
            $fallbackValue = $modelOrAttributes->{$this->fallbackAttribute};
        } elseif (is_array($modelOrAttributes)) {
            $fallbackValue = $modelOrAttributes[$this->fallbackAttribute] ?? '';
        } else {
            return '';
        }

        return $this->slugify($fallbackValue);
    }

    /**
     * Helper function to slugify a given string.
     * Converts the string to lowercase, removes special characters,
     * and replaces spaces with the separator character.
     *
     * @param string $value The string to slugify.
     * @return string The slugified string.
     */
    protected function slugify(string $value): string
    {
        $value = mb_strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', $this->separator, $value);
        return trim($value, $this->separator);
    }
}
