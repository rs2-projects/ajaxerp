<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

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
        $path = $this->getServicePath($name);

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
        // Customize this method to generate the content of your service class
        // For example, you can use a stub file or manually generate the content
        $namespace = implode('\\', explode('/', $name));
        return "<?php\n\nnamespace App\Services\\{$namespace};\n\nclass {$name}\n{\n    // Your code here\n}\n";
    }
}
