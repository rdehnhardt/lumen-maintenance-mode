<?php

namespace Rdehnhardt\MaintenanceMode;

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
     * @throws Exceptions\FileException
     */
    public function setDownMode()
    {
        $file = $this->maintenanceFilePath();

        if (!touch($file)) {
            $message = sprintf(
                'Something went wrong on trying to create maintenance file %s.',
                $file
            );

            throw new Exceptions\FileException($message);
        }

        return true;
    }

    /**
     * Put application in up mode.
     *
     * @return bool true if success and false if something fails.
     * @throws Exceptions\FileException
     */
    public function setUpMode()
    {
        $file = $this->maintenanceFilePath();

        if (file_exists($file) && !unlink($file)) {
            $message = sprintf(
                'Something went wrong on trying to remove maintenance file %s.',
                $file
            );

            throw new Exceptions\FileException($message);
        }

        return true;
    }

    /**
     * Checks if this IP released for access.
     *
     * @return boll
     */
    public function allowedIp()
    {
        $ips = explode(',', env('ALLOWED_IPS'));

        if (is_array($ips) && count($ips)) {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            return in_array($ip, $ips);
        }

        return true;
    }

}
