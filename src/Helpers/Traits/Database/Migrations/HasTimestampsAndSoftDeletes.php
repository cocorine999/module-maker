<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;


/**
 * Trait HasTimestampsAndSoftDeletes
 *
 * This trait combines the functionality of adding timestamps and soft deletes columns to a table.
 * It uses the HasTimestamps and HasSoftDeletes traits.
 *
 * @package LaravelCoreModule\CoreModuleMaker\Helpers\Helpers\Traits\Migrations
 */
trait HasTimestampsAndSoftDeletes
{
    use HasTimestamps;

    /**
     * Add the timestamps and soft deletes columns to the table.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @return void
     */
    public function addTimestampsAndSoftDeletesColumns(Blueprint $table)
    {
        $this->addTimestampsColumns($table);
        $table->softDeletes();
    }
}
