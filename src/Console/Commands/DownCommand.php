<?php

namespace Rdehnhardt\MaintenanceMode\Console\Commands;

use Illuminate\Console\Command;
use Rdehnhardt\MaintenanceMode\MaintenanceModeService;

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
        if ($this->maintenance->isUpMode()) {
            $this->setDownMode();
        } else {
            $this->info('The application is already in maintenance mode!');
        }
    }

    /**
     * Set Application Down Mode.
     *
     * @return void
     */
    public function setDownMode()
    {
        if ($this->maintenance->setDownMode()) {
            $this->info('Application is now in maintenance mode.');
        } else {
            $this->error(
                sprintf(
                    "Something went wrong on trying to create maintenance file %s.",
                    $this->maintenance->maintenanceFilePath()
                )
            );
        }
    }
}
