<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RegisterDynamicProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:dynamic-provider {name}
                                                    {--force : Force create the repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a service provider and register it';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');


        // Generate the provider class
        $providerClass = Str::studly($name);
        $providerPath = app_path('Providers/' . $providerClass . '.php');

        // Check if the provider already exists
        if (!$this->option('force') && File::exists($providerPath)) {
            $this->error("Provider {$providerClass} already exists.");
            return;
        }

        if ($this->option('force') || !file_exists($providerPath)) {
            // Create the provider class
            $this->call('make:provider', [
                'name' => $providerClass,
            ]);

            // Register the provider in config/app.php
            $this->registerServiceProviderInAppServiceProvider($providerClass);
            
            $this->info("Repository provider '$providerClass' created successfully.\n");
        } else {
            $this->info("Repository provider '$providerClass' already exists.\n");
        }

        $this->info("Provider '$providerClass' registered in config/app.php.\n");
    }

    protected function registerServiceProviderInAppServiceProvider($providerClass)
    {
        $appServiceProviderPath = app_path('Providers/AppServiceProvider.php');

        if (file_exists($appServiceProviderPath)) {
            $appServiceProviderContent = file_get_contents($appServiceProviderPath);

            // Add registration code for the new provider
            $registrationCode = "\App\Providers\\" . $providerClass . "::class";

            if (!Str::contains($appServiceProviderContent, $registrationCode)) {
                // Add registration code to the providers array in AppServiceProvider

                $newMethod = "public function register(): void\n\t{\n\t\t\$this->app->register({$registrationCode});\n";
                    
                // Find the existing method based on its name and signature
                $pattern = '/public\s+function\s+register\(\):\s+void\s*{/';

                if (preg_match($pattern, $appServiceProviderContent, $matches)) {

                    $existingMethod = $matches[0];

                    // Replace the existing method with the modified method
                    $modifiedContents = str_replace($existingMethod, $newMethod, $appServiceProviderContent);

                    $comment_pattern = '/\/\*\*.*?Register services\..*?\*\//s';
                    $replacement = "/**\n\t * Register services.\n\t *\n\t * This method is responsible for registering the repository implementations for user-related operations.\n\t * It binds the ReadOnlyRepositoryInterface to the UserReadOnlyRepository and the ReadWriteRepositoryInterface to the UserReadWriteRepository.\n\t * These bindings define which repository implementation should be used when the corresponding interface is requested.\n\t *\n\t * @return void\n\t */";

                    $providerPath=app_path("Providers/{$providerClass}.php");
                    $providerContent = file_get_contents($providerPath);
        
                    if (preg_match($comment_pattern, $providerContent, $matches)) {
                        $comment = preg_replace($comment_pattern, $replacement, $providerContent);
                        file_put_contents($providerPath, $comment);
                    }

                    file_put_contents($appServiceProviderPath, $modifiedContents);
                    echo "Method 'register' has been modified successfully.\n";
                } else {
                    echo "Method 'register' not found in the file.";
                }
            }
        }
    }


    protected function addToServiceProvider($providerClass)
    {
        $appServiceProviderPath = app_path("Providers/{$providerClass}.php");

        if (file_exists($appServiceProviderPath)) {
            $appServiceProviderContent = file_get_contents($appServiceProviderPath);

            // Add registration code for the new provider
            $registrationCode = "{{new_confi}}";

            if (!Str::contains($appServiceProviderContent, $registrationCode)) {
                // Add registration code to the providers array in AppServiceProvider

                $newMethod = "public function register(): void\n\t{\n\t\t$registrationCode\n";
                    
                // Find the existing method based on its name and signature
                $pattern = '/public\s+function\s+register\(\):\s+void\s*{/';

                if (preg_match($pattern, $appServiceProviderContent, $matches)) {

                    $existingMethod = $matches[0];

                    // Replace the existing method with the modified method
                    $modifiedContents = str_replace($existingMethod, $newMethod, $appServiceProviderContent);

                    file_put_contents($appServiceProviderPath, $modifiedContents);
                    ///echo "Method 'register' has been modified successfully.\n";
                } else {
                    echo "Method 'register' not found in the file.";
                }
            }
        }
    }
}
