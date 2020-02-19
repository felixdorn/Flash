<?php


namespace Felix\Tests\Flash\Drivers;


use Felix\Flash\Drivers\SessionDriver;
use Felix\Flash\FlashData;
use Felix\Tests\Flash\TestCase;

class SessionDriverTest extends TestCase
{
    public function test_clear()
    {
        $driver = new SessionDriver([], [
            'flash' => [
                'a' => ['b', 'c']
            ]
        ]);
        $driver->clear();

        $this->assertEquals([], $driver->all());
    }

    public function test_push()
    {
        $data = new FlashData('theType', 'theMessage');
        $driver = new SessionDriver([], ['flash' => []]);

        $driver->push($data);

        $this->assertEquals([
            'theType' => [
                'theMessage'
            ]
        ], $driver->all());
    }

    public function test_all()
    {
        $driver = new SessionDriver([], [
            'flash' => [
                'a' => ['b', 'c']
            ]
        ]);

        $this->assertEquals([
            'a' => ['b', 'c']
        ], $driver->all());

        $this->assertEquals([
            'b', 'c'
        ], $driver->all('a'));

        $this->assertEquals(
            [],
            $driver->all('doesNotExists')
        );
    }
}