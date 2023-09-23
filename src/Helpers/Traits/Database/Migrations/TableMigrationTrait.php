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


    /**
     * Delete columns from an existing table.
     *
     * This method is used to remove specific columns from an existing table in the database. It allows you to drop columns
     * using the provided closure to specify which columns to remove.
     *
     * @param  string   $table_name                          The name of the table to modify.
     * @param  \Closure $column_removal_definition           The closure defining the columns to remove.
     * @return void
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\DatabaseMigrationException  If the table does not exist.
     */
    protected function deleteColumns(string $table_name, \Closure $column_removal_definition): void
    {
        if (!Schema::hasTable($table_name)) {
            throw new \LaravelCoreModule\CoreModuleMaker\Exceptions\DatabaseMigrationException("Cannot modify '$table_name' table as it does not exist.");
        }

        Schema::table($table_name, function (\Illuminate\Database\Schema\Blueprint $table) use ($column_removal_definition) {
            $column_removal_definition($table); // Call the provided closure to specify which columns to remove.
        });
    }

    /**
     * Drop multiple columns from a table, removing their foreign key constraints if any.
     *
     * This method is used to drop specified columns from an existing table in the database. If any of the columns have foreign key
     * constraints, they will be removed before dropping the columns.
     * 
     * @param  string   $table_name       The name of the table from which to drop columns.
     * @param  array    $column_names     An array of column names to drop from the table.
     * @return void
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\DatabaseMigrationException  If the table does not exist or if any of the specified columns do not exist.
     */
    protected function dropColumns(string $table_name, \Closure $column_removal_definition, array $column_names = []): void
    {
        if (!Schema::hasTable($table_name)) {
            throw new \LaravelCoreModule\CoreModuleMaker\Exceptions\DatabaseMigrationException("Cannot drop columns from '$table_name' as the table does not exist.");
        }

        Schema::table($table_name, function (\Illuminate\Database\Schema\Blueprint $table) use ($column_removal_definition) {
            $column_removal_definition($table); // Call the provided closure to specify which columns to remove.
        });

        if(!empty($column_names))
        {
            Schema::table($table_name, function (\Illuminate\Database\Schema\Blueprint $table) use ($table_name, $column_names) {
                foreach ($column_names as $column_name) {
                    if (!$table->hasColumn($column_name)) {
                        throw new \LaravelCoreModule\CoreModuleMaker\Exceptions\DatabaseMigrationException("Cannot drop column '$column_name' from '$table_name' as it does not exist.");
                    }
                }

                // Remove foreign constraints from the specified columns.
                $this->removeForeignConstraints($table_name, $column_names);

                // Now, drop the specified columns.
                $table->dropColumns($column_names); // Drop the specified columns.
            });
        }
    }

    /**
     * Alter an existing table by adding, modifying, setting constraints, or deleting columns.
     *
     * This method is used to alter an existing table in the database by adding new columns,
     * modifying the table schema, setting constraints, or deleting columns.
     *
     * @param string $table_name The name of the table to alter.
     * @param \Closure $alteration_definition The closure defining the alterations to the table.
     * @return void
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\DatabaseMigrationException If the table does not exist.
     */
    protected function alterTable(string $table_name, \Closure $alteration_definition, $conditions): void
    {
        if (!Schema::hasTable($table_name)) {
            throw new \LaravelCoreModule\CoreModuleMaker\Exceptions\DatabaseMigrationException("Cannot alter '$table_name' table as it does not exist.");
        }

        Schema::table($table_name, function (\Illuminate\Database\Schema\Blueprint $table) use ($alteration_definition) {
            // Call the provided closure to define alterations to the table.
            $alteration_definition($table);
        });
    }


    /**
     * Remove foreign key constraints from specified columns of a table.
     *
     * @param  string   $table_name    The name of the table.
     * @param  array    $column_names  An array of column names with foreign key constraints to be removed.
     * @return void
     */
    protected function removeForeignConstraints(string $table_name, array $column_names): void
    {
        // Get the foreign keys for the specified table.
        $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys($table_name);

        foreach ($foreignKeys as $foreignKey) {
            // Check if the foreign key's local column is one of the columns to be modified.
            if (in_array($foreignKey->getLocalColumns()[0], $column_names)) {
                // Drop the foreign key constraint.
                Schema::table($table_name, function ($table) use ($foreignKey) {
                    $table->dropForeign($foreignKey->getName());
                });
            }
        }
    }


    /**
     * Remove foreign keys constraints from a table.
     *
     * This method is used to remove foreign key constraints from an existing table in the database.
     *
     * @param  string   $table_name         The name of the table from which to remove foreign constraints.
     * @param  array    $foreign_keys       An array of foreign key names to remove from the table.
     * @return void
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\DatabaseMigrationException  If the table does not exist or if any of the specified foreign keys do not exist.
     */
    protected function removeForeignKeysConstraints(string $table_name, array $foreign_keys): void
    {
        if (!Schema::hasTable($table_name)) {
            throw new \LaravelCoreModule\CoreModuleMaker\Exceptions\DatabaseMigrationException("Cannot remove foreign constraints from '$table_name' as the table does not exist.");
        }

        Schema::table($table_name, function (\Illuminate\Database\Schema\Blueprint $table) use ($table_name, $foreign_keys) {
            foreach ($foreign_keys as $foreign_key) {
                if (!$table->hasForeign($foreign_key)) {
                    throw new \LaravelCoreModule\CoreModuleMaker\Exceptions\DatabaseMigrationException("Cannot remove foreign key '$foreign_key' from '$table_name' as it does not exist.");
                }
            }

            $table->dropForeign($foreign_keys); // Remove the specified foreign key constraints.
        });
    }

}