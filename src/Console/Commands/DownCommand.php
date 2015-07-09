<?php namespace Rdehnhardt\MaintenanceMode\Console\Commands;

use Illuminate\Console\Command;

class DownCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'down';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Put the application into maintenance mode.";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (!file_exists(storage_path('framework/down'))) {
            touch(storage_path('framework/down'));

            $this->info('Application is now in maintenance mode.');
        } else {
            $this->info('The application is already in maintenance mode!');
        }
    }

}
