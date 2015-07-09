<?php namespace Rdehnhardt\MaintenanceMode\Console\Commands;

use Illuminate\Console\Command;

class UpCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Bring the application out of maintenance mode.";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (file_exists(storage_path('framework/down'))) {
            unlink(storage_path('framework/down'));
            $this->info('Application is now live.');
        } else {
            $this->info('The application was already alive.');
        }
    }

}
