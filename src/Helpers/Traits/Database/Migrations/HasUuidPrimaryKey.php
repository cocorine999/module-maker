<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations;


/**
 * Trait ***`HasUuidPrimaryKey`***
 *
 * The `HasUuidPrimaryKey` trait provides a reusable method for setting a UUID primary key on a database table.
 * It encapsulates the logic for defining the `id` column as a UUID and setting it as the primary key.
 * This trait can be included in any migration class that requires a UUID primary key.
 *
 * Example Usage:
 *
 * ```php
 * use LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations\HasUuidPrimaryKey;
 * use Illuminate\Database\Migrations\Migration;
 * use Illuminate\Database\Schema\Blueprint;
 * use Illuminate\Support\Facades\Schema;
 *
 * class CreateExampleTable extends Migration
 * {
 *     use HasUuidPrimaryKey;
 *
 *     public function up()
 *     {
 *         Schema::create('example_table', function (Blueprint $table) {
 *             // Set UUID primary key
 *             $this->uuidPrimaryKey($table);
 *
 *             // Add other columns to the table
 *         });
 *     }
 *
 *     // ...
 * }
 * ```
 *
 * @package ***`LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations`***
 */
trait HasUuidPrimaryKey
{
    /**
     * Set the UUID primary key on the provided table.
     *
     * @param  \Illuminate\Database\Schema\Blueprint  $table The table blueprint to add the UUID primary key to.
     * @return void
     */
    protected function uuidPrimaryKey(\Illuminate\Database\Schema\Blueprint $table): void
    {
        $table->uuid('id')->primary();
    }
}