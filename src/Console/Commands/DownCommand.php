<?php

namespace Rdehnhardt\MaintenanceMode\Console\Commands;

class DownCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected $name = 'down';

    /**
     * @inheritdoc
     */
    protected $description = 'Put the application into maintenance mode.';

    /**
     * @inheritdoc
     */
    public function fire()
    {
        if ($this->maintenance->isUpMode()) {
            $this->setDownMode();
        } else {
            $this->info('The application is already in maintenance mode!');
        }
    }
}
