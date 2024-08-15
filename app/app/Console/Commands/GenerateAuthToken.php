<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateAuthToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-auth-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new auth token for the application';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $token = Str::random(32);
        $envFile = base_path('.env');

        if (file_exists($envFile)) {
            $envContent = file_get_contents($envFile);
            $pattern = '/^API_TOKEN=.*$/m';

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, "API_TOKEN=$token", $envContent);
            } else {
                $envContent .= PHP_EOL . "API_TOKEN=$token";
            }

            file_put_contents($envFile, $envContent);
            $this->info("Token generated and added to .env file: $token");
        } else {
            $this->error('.env file not found.');
        }
    }
}
