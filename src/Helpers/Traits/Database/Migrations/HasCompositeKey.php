<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations;


/**
 * Trait ***`HasCompositeKey`***
 *
 * This trait provides a convenient method to add a composite index constraint to a table.
 *
 * Example Usage:
 *
 * ```php
 * use LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations\HasCompositeKey;
 * use Illuminate\Database\Migrations\Migration;
 * use Illuminate\Database\Schema\Blueprint;
 * use Illuminate\Support\Facades\Schema;
 *
 * class HasCompositeKey extends Migration
 * {
 *     use HasCompositeKey;
 *
 *     public function up()
 *     {
 *         Schema::table('table_name', function (Blueprint $table) {
 *             $table->index($keys)->after($afterColumnName);
 *         });
 *     }
 *
 *     // ...
 * }
 * ```
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations`***
 */
trait HasCompositeKey
{
    /**
     * Add a composite index column to the table.
     *
     * @param  \Illuminate\Database\Schema\Blueprint $table
     * @param  string|null $columnName
     * @return void
     */
    protected function compositeKeys(\Illuminate\Database\Schema\Blueprint $table, array $keys = ['status'], string $afterColumnName = 'id'): void {
        $table->index($keys)->after($afterColumnName);
    }
}
