<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations;


/**
 * Trait ***`CanDeleteTrait`***
 *
 * This trait provides a method to add the `can_be_deleted` column to a database table.
 *
 * @package ***`LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations`***
 */
trait CanDeleteTrait
{
    /**
     * Add the `can_be_deleted` column to the table.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @return void
     */
    protected function addCanDeleteColumn(\Illuminate\Database\Schema\Blueprint $table, string $column_name = 'can_be_deleted', bool $can_be_deleted = true)
    {
        $table->boolean($column_name)->default($can_be_deleted);
    }
}