<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations;

use Illuminate\Support\Facades\Schema;


/**
 * Trait ***`TableMigrationTrait`***
 * 
 * The `TableMigrationTrait` provides a set of common features for creating and modifying database tables. It includes
 * traits for managing `UUID primary keys`, `timestamps`, `foreign keys`, and a custom trait for adding a `can_be_deleted`
 * column to tables. This trait is designed to be used in migration classes to simplify the process of defining and
 * modifying database tables with commonly used features.
 *
 * @package ***`LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations`***
 */
trait TableMigrationTrait
{
    use CanDeleteTrait, HasForeignKey, HasMatricule, HasTimestamps, HasUuidPrimaryKey;

    /**
     * Create a table with common features.
     *
     * This method is used to create a new table in the database with common features that are frequently used in
     * application tables. It creates a new table using the provided closure to define additional columns.
     *
     * @param  string   $table_name                  The name of the table to create.
     * @param  bool     $can_be_deleted (optional)  Whether to add the `can_be_deleted` column to the table (default: true).
     * @param  \Closure $column_definition           The closure defining the table columns.
     * @return void
     */
    protected function createTable(string $table_name, \Closure $column_definition, bool $has_reference = false, $reference_name = null, bool $can_be_deleted = true, string $can_be_deleted_column_name = 'can_be_deleted', bool $has_foreign_key = true): void
    {
        // Check if the "$table_name" table does not exist
        if (! Schema::hasTable($table_name)) {
            Schema::create($table_name, function (\Illuminate\Database\Schema\Blueprint $table) use ($column_definition, $has_reference, $reference_name, $has_foreign_key, $can_be_deleted_column_name, $can_be_deleted) {
                $this->uuidPrimaryKey($table);
                if($has_reference) {
                    // "matricule" column with uniqueness constraint
                    $this->addMatriculeColumn($table, $reference_name ?? "matricule");}
                $column_definition($table); // Call the provided closure to define additional columns.

                // Colonne "status" avec valeur par défaut TRUE
                $table->boolean('status')->default(TRUE);

                $this->addCanDeleteColumn(table: $table, column_name: $can_be_deleted_column_name, can_be_deleted: $can_be_deleted);
                if($has_foreign_key)
                    $this->foreignKey(table: $table, column: 'created_by', references: 'users', nullable: true);
                $this->addTimestampsColumns($table);

                $table->softDeletes();
            });
        }
    }
    
    /**
     * Modify a table with common features.
     *
     * This method is used to modify an existing table in the database with common features that are frequently used in
     * application tables. It modifies an existing table using the provided closure to define additional columns.
     *
     * @param  string   $table_name                          The name of the table to modify.
     * @param  \Closure $column_definition                   The closure defining the table columns.
     * @return void
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\DatabaseMigrationException  If the table does not exist.
     */
    protected function modifyTable(string $table_name, \Closure $column_definition): void
    {
        if (!Schema::hasTable($table_name)) {
            throw new \LaravelCoreModule\CoreModuleMaker\Exceptions\DatabaseMigrationException("Cannot modify '$table_name' table as it does not exist.");
        }

        Schema::table($table_name, function (\Illuminate\Database\Schema\Blueprint $table) use ($column_definition) {
            $column_definition($table); // Call the provided closure to define additional columns.
        });
    }

}