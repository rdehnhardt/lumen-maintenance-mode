<?php

namespace Rdehnhardt\MaintenanceMode\Console\Commands;

class UpCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected $name = 'up';

    /**
     * @inheritdoc
     */
    protected $description = 'Bring the application out of maintenance mode.';

    /**
     * @inheritdoc
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
