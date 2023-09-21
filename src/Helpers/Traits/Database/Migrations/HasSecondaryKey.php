<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations;


/**
 * Trait ***`HasSecondaryKey`***
 *
 * This trait provides a convenient method to add a foreign key constraint to a table.
 *
 * Example Usage:
 *
 * ```php
 * use LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations\HasSecondaryKey;
 * use Illuminate\Database\Migrations\Migration;
 * use Illuminate\Database\Schema\Blueprint;
 * use Illuminate\Support\Facades\Schema;
 *
 * class AddForeignKeyColumn extends Migration
 * {
 *     use HasSecondaryKey;
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
trait HasSecondaryKey
{
    /**
     * Add a secondray key column to the table.
     *
     * @param  \Illuminate\Database\Schema\Blueprint $table
     * @param  string|null $columnName
     * @return void
     */
    protected function secondaryKey(\Illuminate\Database\Schema\Blueprint $table, ?string $columnName = 'matricule', string $afterColumnName = 'id'): void {
        $table->string($columnName)->unique()->after($afterColumnName);
    }
}
