<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\DataTransfertObjects;


/**
 * **`Interface FilterDTOContract`**
 *
 * The FilterDTOContract interface defines the contract for filter data transfert objects.
 * Filter data transfert objects are used to encapsulate filtering criteria for querying data.
 *
 * @package LaravelCoreModule\CoreModuleMaker\DataTransfertObjects
 */
interface FilterDTOContract
{
    /**
     * Get the filter criteria as an associative array.
     *
     * @return array The filter criteria.
     */
    public function getCriteria(): array;

    /**
     * Set the filter criteria from an array.
     *
     * @param array $criteria The filter criteria.
     * @return void
     */
    public function setCriteria(array $criteria): void;

    /**
     * Remove a filter criteria.
     *
     * @param string $key The filter criteria key.
     * @return void
     */
    public function removeCriteria(string $key): void;

    /**
     * Add a filter element to the criteria.
     *
     * @param  string $column        The column name.
     * @param  mixed  $value         The column value.
     * @param  string $comparator    The comparator for the filter element.
     * @param  string $queryFunction The query function for the filter element.
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addFilterElement(string $column, $value, string $comparator, string $queryFunction): void;

    /**
     * Check if a filter criteria exists.
     *
     * @param string $key The filter criteria key.
     * @return bool True if the filter criteria exists, false otherwise.
     */
    public function hasCriteria(string $key): bool;

    /**
     * Get the sorting field.
     *
     * @return string|null The sorting field.
     */
    public function getSortField(): ?string;

    /**
     * Get the sorting order.
     *
     * @return string|null The sorting order.
     */
    public function getSortOrder(): ?string;

    /**
     * Get the pagination page number.
     *
     * @return int|null The page number.
     */
    public function getPage(): ?int;

    /**
     * Get the pagination limit.
     *
     * @return int|null The limit.
     */
    public function getLimit(): ?int;

    /**
     * Clear all the filter parameters.
     *
     * @return void
     */
    public function clearFilter(): void;

    /**
     * Validate the filter criteria.
     *
     * @param  array $criteria The filter criteria.
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateCriteria(array $criteria): void;

    /**
     * Validate the filter data.
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException If the validation fails.
     */
    public function validateFilterElement(array $filterElement): void;

    /**
     * Get the filter data as an associative array.
     *
     * @return array The filter data.
     */
    public function toArray(): array;
}
