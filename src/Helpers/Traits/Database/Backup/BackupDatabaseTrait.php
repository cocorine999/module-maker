<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Backup;


/**
 * Trait ***`BackupDatabaseTrait`***
 * 
 * This trait provides a method to backup the database before running migrations.
 * It uses the spatie/laravel-backup package for database backup.
 * 
 * @package ***`LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Database\Backup`***
 */
trait BackupDatabaseTrait
{

    /**
     * Backup the database.
     *
     * @return void
     */
    protected function backupDatabase(): void
    {
        // Ensure the backup directory exists
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        // Generate the backup file name with timestamp
        $backupFileName = 'backup-' . date('Y-m-d-His') . '.zip';

        // Execute the backup command using the spatie/laravel-backup package
        //\Spatie\Backup\Tasks\Backup\BackupJobFactory::createFromArray(config('backup'))->run();

        // Move the backup to the storage directory
        rename(storage_path('app/' . config('backup.name') . '/' . $backupFileName), storage_path('app/backups/' . $backupFileName));

        // Clean up the temporary backup directory
        rmdir(storage_path('app/' . config('backup.name')));
    }
}