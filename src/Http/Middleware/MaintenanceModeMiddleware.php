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
            return response(view('errors.503'), 503);
        }

        return $next($request);
    }

}
