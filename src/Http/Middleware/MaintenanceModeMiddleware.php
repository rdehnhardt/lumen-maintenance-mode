<?php namespace Rdehnhardt\MaintenanceMode\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;

class MaintenanceModeMiddleware
{

    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function handle($request, Closure $next)
    {
        if (file_exists(storage_path('framework/down'))) {
            if (view()->exists('errors.503')) {
                return response(view('errors.503'), 503);
            } else {
                return app()->abort(503);
            }
        }

        return $next($request);
    }

}
