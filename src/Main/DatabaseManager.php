<?php

namespace InstallerErag\Main;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class DatabaseManager
{
    /**
     * Migrate and seed the database.
     */
    public static function MigrateAndSeed(): array
    {
        $dm = new DatabaseManager;
        $outputLog = new BufferedOutput;

        return $dm->migrate($outputLog);
    }

    /**
     * Run the migration and call the seeder.
     */
    public function migrate(BufferedOutput $outputLog): array
    {
        try {
            Artisan::call('migrate:fresh', [
                '--force' => true, // You can use --force to avoid prompts if needed
            ], $outputLog);
            return ['success', $outputLog];
        } catch (Exception $e) {
            return ['error', $outputLog];
        }

        // return $this->seed($outputLog);
    }

    /**
     * Seed the database.
     */
    public function seed(BufferedOutput $outputLog): array
    {
        try {
            Artisan::call('db:seed', ['--force' => true], $outputLog);

            return ['success', $outputLog];
        } catch (Exception $e) {
            return ['error', $outputLog];
        }
    }
}
