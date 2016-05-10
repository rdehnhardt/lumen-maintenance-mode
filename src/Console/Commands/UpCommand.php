<?php

namespace Rdehnhardt\MaintenanceMode\Console\Commands;

class UpCommand extends Command
{
    /**
     * @var string $name
     */
    protected $name = 'up';

    /**
     * @var string $description
     */
    protected $description = 'Bring the application out of maintenance mode.';

    /**
     * Bring the application out of maintenance mode.
     */
    public function fire()
    {
        if ($this->maintenance->isDownMode()) {
            $this->setUpMode();
        } else {
            $this->info('The application was already alive.');
        }
    }
}
