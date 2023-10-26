<?php

namespace LaravelCoreModule\CoreModuleMaker;

use LaravelCoreModule\CoreModuleMaker\Commands\GenerateController;
use LaravelCoreModule\CoreModuleMaker\Commands\GenerateCreateDTO;
use LaravelCoreModule\CoreModuleMaker\Commands\GenerateCreateRequest;
use LaravelCoreModule\CoreModuleMaker\Commands\GenerateCrudRoutes;
use LaravelCoreModule\CoreModuleMaker\Commands\GenerateDTO;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use LaravelCoreModule\CoreModuleMaker\PackageServiceProvider as CoreServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use LaravelCoreModule\CoreModuleMaker\Commands\GenerateModel;
use LaravelCoreModule\CoreModuleMaker\Commands\GenerateMigration;
use LaravelCoreModule\CoreModuleMaker\Commands\GenerateRepository;
use LaravelCoreModule\CoreModuleMaker\Commands\GenerateService;
use LaravelCoreModule\CoreModuleMaker\Commands\GenerateUpdateDTO;
use LaravelCoreModule\CoreModuleMaker\Commands\GenerateUpdateRequest;
use LaravelCoreModule\CoreModuleMaker\Commands\RegisterDynamicProvider;
use LaravelCoreModule\CoreModuleMaker\Providers\ActivityLogServiceProvider;

class CoreModuleMakerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('core-modules-maker')
            ->hasConfigFile(["core-modules-maker"])
            ->hasMigration('create_core-modules-maker_table')
            //->publishesServiceProvider('MyProviderName')
            ->hasCommands([
                GenerateMigration::class,
                GenerateModel::class,
                GenerateRepository::class,
                GenerateService::class,
                GenerateDTO::class,
                GenerateCreateDTO::class,
                GenerateUpdateDTO::class,
                GenerateController::class,
                GenerateCreateRequest::class,
                GenerateUpdateRequest::class,
                GenerateCrudRoutes::class,
                RegisterDynamicProvider::class
            ])
            ->hasInstallCommand(function(InstallCommand $command) {
               $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub("laravel-core-modules/core-modules-maker")
                    ->endWith(function (InstallCommand $installCommand) {
                        $installCommand->line('');
                        $installCommand->info("We've added app\Providers\DynamicServersProvider to your project.");
                        $installCommand->info("Feel free to customize it to your needs.");
                        $installCommand->line('');
                        $installCommand->info('You can view all docs at https://spatie.be/docs/laravel-dynamic-servers');
                        $installCommand->line('');
                        $installCommand->info('Thank you very much for installing this package!');
                    });
           });
        //require_once(__DIR__. "/Helpers/Mixins/Helpers.php");

		$this->app->register(CoreServiceProvider::class);
		///$this->app->register(ActivityLogServiceProvider::class);
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/laravel-core-modules/core-modules-maker'),
        ], 'translations');

    }
}
