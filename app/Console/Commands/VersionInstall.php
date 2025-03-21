<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VersionInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'version:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepares the environment for a new version';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Preparing new version');
        $this->newLine();
        $this->commonCommands();

        app()->isProduction() ? $this->productionCommands() : $this->localCommands();
    }

    private function commonCommands(): void
    {
        $this->info("--- Running migrations ---");
        $this->newLine();

        $this->call('migrate', ['--force' => true]);
    }

    private function productionCommands(): void
    {
        $this->call('route:cache');
        $this->call('view:cache');
        $this->call('config:cache');
        $this->call('optimize');
    }

    private function localCommands(): void
    {
        $this->call('optimize:clear');
    }
}
