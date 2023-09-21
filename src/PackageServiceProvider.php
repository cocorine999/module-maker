<?php

namespace LaravelCoreModule\CoreModuleMaker;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Date;
use LaravelCoreModule\CoreModuleMaker\Repositories\Contracts\ReadOnlyRepositoryInterface;
use LaravelCoreModule\CoreModuleMaker\Repositories\Contracts\ReadWriteRepositoryInterface;
use LaravelCoreModule\CoreModuleMaker\Repositories\Eloquent\EloquentReadOnlyRepository;
use LaravelCoreModule\CoreModuleMaker\Repositories\Eloquent\EloquentReadWriteRepository;
use LaravelCoreModule\CoreModuleMaker\Services\Contracts\QueryServiceContract;
use LaravelCoreModule\CoreModuleMaker\Services\Contracts\ReadWriteServiceContract;
use LaravelCoreModule\CoreModuleMaker\Services\Manager\QueryService;
use LaravelCoreModule\CoreModuleMaker\Services\Manager\ReadWriteService;
use LaravelCoreModule\CoreModuleMaker\Services\RestJson\Contracts\RestJsonQueryServiceContract;
use LaravelCoreModule\CoreModuleMaker\Services\RestJson\Contracts\RestJsonReadWriteServiceContract;
use LaravelCoreModule\CoreModuleMaker\Services\RestJson\RestJsonQueryService;
use LaravelCoreModule\CoreModuleMaker\Services\RestJson\RestJsonReadWriteService;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
	{

        // Binds ReadOnlyRepositoryInterface to EloquentReadOnlyRepository
        $this->app->bind(ReadOnlyRepositoryInterface::class, EloquentReadOnlyRepository::class);

        // Binds ReadWriteRepositoryInterface to EloquentReadWriteRepository
        $this->app->bind(ReadWriteRepositoryInterface::class, EloquentReadWriteRepository::class);
        
        /**
         * Binds implementations to their respective interfaces in the application's service container.
         * This allows for dependency injection and facilitates the use of interfaces throughout the application.
         */

        // Binds the implementation of QueryServiceContract to the QueryService class.
        $this->app->bind(
            QueryServiceContract::class,
            function ($app) {
                // Resolve the dependencies required by QueryService
                $readOnlyRepository = $app->make(ReadOnlyRepositoryInterface::class);

                // Create and return an instance of QueryService
                return new QueryService($readOnlyRepository);
            }
        );

        // Binds the implementation of ReadWriteServiceContract to the ReadWriteService class.
        $this->app->bind(
            ReadWriteServiceContract::class,
            function ($app) {
                // Resolve the dependencies required by ReadWriteService
                $readWriteRepository = $app->make(ReadWriteRepositoryInterface::class);

                // Create and return an instance of ReadWriteService
                return new ReadWriteService($readWriteRepository);
            }
        );



        // Binds the implementation of RestJsonQueryServiceContract to the RestJsonQueryService class.
        $this->app->bind(
            RestJsonQueryServiceContract::class,
            function ($app) {
                // Resolve the dependencies required by RestJsonQueryService
                $readOnlyRepository = $app->make(ReadOnlyRepositoryInterface::class);
                $queryService = $app->make(QueryServiceContract::class, [$readOnlyRepository]);

                // Create and return an instance of RestJsonQueryService
                return new RestJsonQueryService($queryService);
            }
        );

        // Binds the implementation of RestJsonReadWriteServiceContract to the RestJsonReadWriteService class.
        $this->app->bind(
            RestJsonReadWriteServiceContract::class,
            function ($app) {
                // Resolve the dependencies required by RestJsonReadWriteService
                $readWriteRepository = $app->make(ReadWriteRepositoryInterface::class);

                $queryService = new ReadWriteService($readWriteRepository);

                // Create and return an instance of RestJsonReadWriteService
                return new RestJsonReadWriteService($queryService);
            }
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {    

        Validator::extend('max_age', function ($attribute, $value, $parameters, $validator) {
            $maxAge = $parameters[0] ?? 100; // Default max age is 100 years
            $date = Date::parse($value);
            $today = Date::now();
            $age = $date->diffInYears($today);

            return $age <= $maxAge;
        });
        ///Validator::extend('morph_exists', 'App\Validation\MorphExistsValidator@validateMorphExists');
    }
}
