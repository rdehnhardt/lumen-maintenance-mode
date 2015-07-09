<?php namespace Rdehnhardt\MaintenanceMode\Providers;

use Illuminate\Support\ServiceProvider;
use Rdehnhardt\MaintenanceMode\Console\Commands\UpCommand;
use Rdehnhardt\MaintenanceMode\Console\Commands\DownCommand;
use Rdehnhardt\MaintenanceMode\Http\Middleware\MaintenanceModeMiddleware;

class MaintenanceModeServiceProvider extends ServiceProvider
{

    protected $defer = true;

    public function register()
    {
        $this->app->middleware([
            MaintenanceModeMiddleware::class,
        ]);

        $this->app->singleton('command.up', function () {
            return new UpCommand();
        });

        $this->app->singleton('command.down', function () {
            return new DownCommand();
        });

        $this->commands(['command.up', 'command.down']);
    }

}
