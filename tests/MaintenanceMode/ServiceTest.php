<?php

namespace Rdehnhardt\MaintenanceMode\Testing;

use Rdehnhardt\MaintenanceMode\MaintenanceModeService;
use Rdehnhardt\MaintenanceMode\Providers\MaintenanceModeServiceProvider;

class ServiceTest extends AbstractTestCase
{
    /**
     * Asserting consecutive calls.
     */
    public function testShouldNotThrowExceptionOnConsecutiveCalls()
    {
        $service = new MaintenanceModeService($this->app);

        $this->assertSetDownMode($service);
        $this->assertSetDownMode($service);

        $this->assertSetUpMode($service);
        $this->assertSetUpMode($service);
    }

    /**
     * Asserting inverted consecutive calls.
     */
    public function testShouldNotThrowExceptionOnConsecutiveCallsInverted()
    {
        $service = new MaintenanceModeService($this->app);

        $this->assertSetUpMode($service);
        $this->assertSetUpMode($service);

        $this->assertSetDownMode($service);
        $this->assertSetDownMode($service);

        $this->assertSetUpMode($service);
    }

    /**
     * Asserting application in down mode.
     */
    public function testShouldApplicationBeInDownMode()
    {
        $this->app->register(MaintenanceModeServiceProvider::class);

        $this->artisan('down');

        $response = $this->call('GET', '/');

        $this->assertEquals(503, $response->getStatusCode());
    }

    /**
     * Asserting application in up mode.
     */
    public function testShouldApplicationBeInUpMode()
    {
        $this->app->register(MaintenanceModeServiceProvider::class);

        $this->artisan('up');

        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @param MaintenanceModeService $service
     */
    public function assertSetUpMode(MaintenanceModeService $service)
    {
        $service->setUpMode();

        $this->assertFileNotExists($service->maintenanceFilePath());
    }

    /**
     * @param MaintenanceModeService $service
     */
    public function assertSetDownMode(MaintenanceModeService $service)
    {
        $service->setDownMode();

        $this->assertFileExists($service->maintenanceFilePath());
    }
}
