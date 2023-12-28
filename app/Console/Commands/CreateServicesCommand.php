<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CreateServicesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:services {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new services class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        Log::info("Creating service class {$name}...");
        $path = $this->getServicePath($name);
        Log::info("Service class path: {$path}");

        if (!File::exists(dirname($path))) {
            // Create the directory if it doesn't exist
            File::makeDirectory(dirname($path), 0755, true);
        }

        // Create the service class file
        File::put($path, $this->generateClass($name));

        $this->info("Service class {$name} created successfully!");
    }

    private function getServicePath($name)
    {
        // Convert namespace to directory path
        $namespaceParts = explode('/', $name);
        $className = array_pop($namespaceParts);
        $directoryPath = implode('/', $namespaceParts);

        // Build the full path
        return base_path("app/Services/{$directoryPath}/{$className}.php");
    }

    private function generateClass($name)
    {
        $namespaceParts = explode('/', $name);
        $className = array_pop($namespaceParts);

        if (count($namespaceParts) > 0) {
            $directoryPath = implode('\\', $namespaceParts);
        } else {
            $directoryPath = '';
        }
        // Customize this method to generate the content of your service class
        // For example, you can use a stub file or manually generate the content

        if($directoryPath == '') {
            $fullNamespace = 'App\Services';
        } else {
            $fullNamespace = 'App\Services\\' . $directoryPath;
        }


        return "<?php\n\nnamespace $fullNamespace;\n\nclass {$className}\n{\n    // Your code here\n}\n";
    }
}
