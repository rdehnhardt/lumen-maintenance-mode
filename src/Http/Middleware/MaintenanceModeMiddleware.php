<?php

namespace Rdehnhardt\MaintenanceMode\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Rdehnhardt\MaintenanceMode\MaintenanceModeService;

class MaintenanceModeMiddleware
{
    /**
     * Maintenance Mode Service.
     *
     * @var \Rdehnhardt\MaintenanceMode\MaintenanceModeService
     */
    protected $maintenance;

    /**
     * Lumen Application Instance.
     *
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    /**
     * View Factory.
     *
     * @var \Illuminate\View\Factory
     */
    protected $view;

    public function __construct(MaintenanceModeService $maintenance, Application $app)
    {
        $this->maintenance = $maintenance;
        $this->app = $app;
        $this->view = $app['view'];
    }

    /**
     * Handle incoming requests.
     *
     * @param Request $request
     * @param \Closure $next
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \InvalidArgumentException
     */
    public function handle($request, Closure $next)
    {
        if ($this->maintenance->isDownMode() && !$this->maintenance->checkAllowedIp($this->getIp())) {
            if ($this->view->exists('errors.503')) {
                return new Response($this->view->make('errors.503'), 503);
            }

            return $this->app->abort(503, 'The application is down for maintenance.');
        }

        return $next($request);
    }

    /**
     * Get client ip
     */
    private function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}
