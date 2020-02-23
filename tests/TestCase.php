<?php

namespace Felix\Tests\Flash;

use Felix\Flash\Drivers\ArrayDriver;
use Felix\Flash\Drivers\SessionDriver;
use Felix\Flash\Flash;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * @var Flash
     */
    protected $flash;
    /**
     * @var ArrayDriver
     */
    protected $driver;

    protected function setUp(): void
    {
        $this->driver = new SessionDriver([], ['flash' => []]);
        $this->flash = new Flash($this->driver, '{value}');
    }
}
