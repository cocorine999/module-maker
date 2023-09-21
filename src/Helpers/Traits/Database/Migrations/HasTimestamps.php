<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations;


/**
 * Trait ***`HasTimestamps`***
 *
 * This trait provides a method to add the `created_at` and `updated_at` timestamps columns to a table.
 *
 * Example Usage:
 *
 * ```php
 * use LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations\HasTimestamps;
 * use Illuminate\Database\Migrations\Migration;
 * use Illuminate\Database\Schema\Blueprint;
 * use Illuminate\Support\Facades\Schema;
 *
 * class CreateExampleTable extends Migration
 * {
 *     use HasTimestamps;
 *
 *     public function up()
 *     {
 *         Schema::create('example_table', function (Blueprint $table) {
 *             $table->id();
 *             // Add other columns to the table
 *
 *             // Add timestamps columns
 *             $this->addTimestampsColumns($table);
 *         });
 *     }
 *
 * }
 * ```
 *
 * @package ***`LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations`***
 */
trait HasTimestamps
{
    /**
     * Add the `created_at` and `updated_at` timestamps columns to the table.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table The table blueprint to add the timestamps columns to.
     * @return void
     */
    protected function addTimestampsColumns(\Illuminate\Database\Schema\Blueprint $table)
    {
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
    }
}