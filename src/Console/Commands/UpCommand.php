<?php namespace Rdehnhardt\MaintenanceMode\Console\Commands;

use Illuminate\Console\Command;
use Rdehnhardt\MaintenanceMode\MaintenanceModeService;

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
     * Maintenance Service.
     *
     * @var MaintenanceModeService
     */
    protected $maintenance;

    /**
     * @param \Rdehnhardt\MaintenanceMode\MaintenanceModeService $maintenance
     */
    public function __construct(MaintenanceModeService $maintenance)
    {
        parent::__construct();

        $this->maintenance = $maintenance;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if ($this->maintenance->isDownMode()) {
            $this->setUpMode();
        } else {
            $this->info('The application was already alive.');
        }
    }

    /**
     * Set Application Up Mode.
     *
     * @return void
     */
    public function setUpMode()
    {
        if ($this->maintenance->setUpMode()) {
            $this->info('Application is now live.');
        } else {
            $this->error(
                sprintf(
                    "Something went wrong on trying to remove maintenance file %s.",
                    $this->maintenance->maintenanceFilePath()
                )
            );
        }
    }
}
