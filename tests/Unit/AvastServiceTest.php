<?php

namespace Tests\Unit;

use App\Services\AvastService;
use Tests\BaseTestCase;

class AvastServiceTest extends BaseTestCase
{
    /**
     * @covers \App\Services\AvastService::run
     */
    public function testCreateAvastService()
    {
        $redis = \Mockery::mock('Redis');
        $service = new AvastService($redis, '');
        $this->assertIsObject($service);
    }

    /**
     * @covers \App\Services\AvastService::run
     */
    public function testExceptionForEmptyFile()
    {
        $redis = \Mockery::mock('Redis');
        $service = new AvastService($redis, '');

        $this->expectException(\Exception::class);
        $service->run(false);
    }

    /**
     * @covers \App\Services\AvastService::getFileExtension
     */
    public function testCheckFileExtension()
    {
        $redis = \Mockery::mock('Redis');
        $service = new AvastService($redis, 'file.pdf');

        $this->assertEquals("pdf", $this->callMethod($service, 'getFileExtension'));
        $this->assertNotEquals("xml", $this->callMethod($service, 'getFileExtension'));
    }
}