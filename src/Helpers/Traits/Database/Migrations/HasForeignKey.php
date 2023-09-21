<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations;


/**
 * Trait ***`HasForeignKey`***
 *
 * This trait provides a convenient method to add a foreign key constraint to a table.
 *
 * Example Usage:
 *
 * ```php
 * use LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations\HasForeignKey;
 * use Illuminate\Database\Migrations\Migration;
 * use Illuminate\Database\Schema\Blueprint;
 * use Illuminate\Support\Facades\Schema;
 *
 * class AddForeignKeyColumn extends Migration
 * {
 *     use HasForeignKey;
 *
 *     public function up()
 *     {
 *         Schema::table('table_name', function (Blueprint $table) {
 *             $this->foreignKey(
 *                 $table,
 *                 'foreign_key_column', // The name of the foreign key column to be added.
 *                 'reference_table',    // The name of the table that the foreign key references.
 *                 'cascade',            // Optional: The on delete behavior (default is 'cascade').
 *                 'cascade',            // Optional: The on update behavior (default is 'cascade').
 *                 'created_at',         // Optional: The name of the column before which the foreign key column should be added (default is 'created_at').
 *                 false                 // Optional: Whether the foreign key column is nullable (default is false).
 *             );
 *         });
 *     }
 *
 *     // ...
 * }
 * ```
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations`***
 */
trait HasForeignKey
{
    /**
     * Set the foreign key constraint on the provided table.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table          The table blueprint to add the foreign key constraint to.
     * @param string                                $column         The name of the foreign key column to be added.
     * @param string                                $references     The name of the table that the foreign key references.
     * @param string|null                           $onDelete       Optional: The on delete behavior (default is 'cascade').
     * @param string|null                           $onUpdate       Optional: The on update behavior (default is 'cascade').
     * @param string                                $beforeColumnName Optional: The name of the column before which the foreign key column should be added (default is 'created_at').
     * @param bool                                  $nullable       Optional: Whether the foreign key column is nullable (default is false).
     * @return void
     */
    protected function foreignKey(
        \Illuminate\Database\Schema\Blueprint $table,
        string $column,
        string $references,
        ?string $onDelete = null,
        ?string $onUpdate = null,
        string $beforeColumnName = 'created_at',
        bool $nullable = false
    ): void {
        $table->foreignUuid($column)
            ->after($beforeColumnName)
            ->nullable($nullable)
            ->constrained($references)
            ->onDelete($onDelete ?? 'cascade');
    }
}
