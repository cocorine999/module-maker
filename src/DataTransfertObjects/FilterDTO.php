<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\DataTransfertObjects;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


/**
 * Class FilterDTO
 *
 * This class represents a Filter DTO (Data Transfer Object) used for filtering data.
 * It encapsulates multiple filter columns with their corresponding values, comparators, and query functions.
 *
 * @package \LaravelCoreModule\CoreModuleMaker\DataTransfertObjects
 */
class FilterDTO implements FilterDTOContract
{
    /**
     * @var array The filter criteria.
     */
    private array $criteria;

    /**
     * @var string|null The sorting field.
     */
    private ?string $sortField;

    /**
     * @var string|null The sorting order.
     */
    private ?string $sortOrder;

    /**
     * @var int|null The pagination page number.
     */
    private ?int $page;

    /**
     * @var int|null The pagination limit.
     */
    private ?int $limit;

    /**
     * FilterDTO constructor.
     *
     * @param array $criteria The filter criteria.
     * @param string|null $sortField The sorting field.
     * @param string|null $sortOrder The sorting order.
     * @param int|null $page The pagination page number.
     * @param int|null $limit The pagination limit.
     */
    public function __construct(
        array $criteria = [],
        ?string $sortField = null,
        ?string $sortOrder = null,
        ?int $page = null,
        ?int $limit = null
    ) {
        $this->criteria = $criteria;
        $this->sortField = $sortField;
        $this->sortOrder = $sortOrder;
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * Get the filter criteria as an associative array.
     *
     * @return array The filter criteria.
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    /**
     * Set the filter criteria using an associative array.
     *
     * @param array $criteria The filter criteria.
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function setCriteria(array $criteria): void
    {
        $this->validateCriteria($criteria);
        $this->criteria = $criteria;
    }

    /**
     * Remove a filter criteria.
     *
     * @param string $key The filter criteria key.
     * @return void
     */
    public function removeCriteria(string $key): void
    {
        unset($this->criteria[$key]);
    }

    /**
     * Check if a filter criteria exists.
     *
     * @param string $key The filter criteria key.
     * @return bool True if the filter criteria exists, false otherwise.
     */
    public function hasCriteria(string $key): bool
    {
        return isset($this->criteria[$key]);
    }

    /**
     * Get the sorting field.
     *
     * @return string|null The sorting field.
     */
    public function getSortField(): ?string
    {
        return $this->sortField;
    }

    /**
     * Get the sorting order.
     *
     * @return string|null The sorting order.
     */
    public function getSortOrder(): ?string
    {
        return $this->sortOrder;
    }

    /**
     * Get the pagination page number.
     *
     * @return int|null The page number.
     */
    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
     * Get the pagination limit.
     *
     * @return int|null The limit.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Clear all the filter parameters.
     *
     * @return void
     */
    public function clearFilter(): void
    {
        $this->criteria = [];
        $this->sortField = null;
        $this->sortOrder = null;
        $this->page = null;
        $this->limit = null;
    }

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
    public function addFilterElement(string $column, $value, string $comparator, string $queryFunction): void
    {
        $filterElement = [
            'column' => $column,
            'value' => $value,
            'comparator' => $comparator,
            'query_function' => $queryFunction,
        ];

        $this->validateFilterElement($filterElement);
        $this->criteria[$column] = $filterElement;
    }

    /**
     * Remove a filter element from the criteria.
     *
     * @param int $index The index of the filter element to remove.
     * @return void
     */
    public function removeFilterElement(int $index): void
    {
        unset($this->criteria[$index]);
    }

    /**
     * Validate the filter criteria.
     *
     * @param array $criteria The filter criteria.
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateCriteria(array $criteria): void
    {
        $validator = Validator::make($criteria, [
            '*.column' => 'required|string',
            '*.value' => 'required',
            '*.comparator' => 'required|string',
            '*.query_function' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Validate a single filter element.
     *
     * @param array $filterElement The filter element.
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateFilterElement(array $filterElement): void
    {
        $this->validateCriteria($filterElement);
    }

    /**
     * Get the filter data as an associative array.
     *
     * @return array The filter data.
     */
    public function toArray(): array
    {
        return [];
    }
}
