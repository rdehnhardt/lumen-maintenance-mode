<?php namespace Rdehnhardt\MaintenanceMode;

use Illuminate\Contracts\Foundation\Application;

class MaintenanceModeService
{
    /**
     * File to verify maintenance mode.
     *
     * @var string
     */
    protected $maintenanceFile = 'framework/down';

    /**
     * Lumen Application instance.
     *
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Verify if application is in maintenance mode.
     *
     * @return bool
     */
    public function isDownMode()
    {
        return $this->maintenanceFileExists();
    }

    /**
     * Verify if application is up.
     *
     * @return bool
     */
    public function isUpMode()
    {
        return !$this->maintenanceFileExists();
    }

    /**
     * Put the application in down mode.
     *
     * @return bool true if success and false if something fails.
     */
    public function setDownMode()
    {
        return touch($this->maintenanceFilePath());
    }

    /**
     * Put application in up mode.
     *
     * @return bool true if success and false if something fails.
     */
    public function setUpMode()
    {
        return unlink($this->maintenanceFilePath());
    }

    /**
     * Indicates if maintenance file exists.
     *
     * @return bool
     */
    public function maintenanceFileExists()
    {
        return file_exists($this->maintenanceFilePath());
    }

    /**
     * Maintenance file path.
     *
     * @return string
     */
    public function maintenanceFilePath()
    {
        return $this->app->storagePath($this->maintenanceFile);
    }
}
