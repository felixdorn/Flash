<?php


namespace Felix\Tests\Flash\Drivers;

use Felix\Flash\Drivers\ArrayDriver;
use Felix\Flash\FlashData;
use Felix\Tests\Flash\TestCase;

class ArrayDriverTest extends TestCase
{
    public function test_clear()
    {
        $driver = new ArrayDriver([
            'a' => ['b', 'c']
        ]);

        $driver->clear();

        $this->assertEquals([], $driver->all());
    }

    public function test_push()
    {
        $data = new FlashData('theType', 'theMessage');

        $this->driver->push($data);

        $this->assertEquals([
            'theType' => [
                'theMessage'
            ]
        ], $this->driver->all());
    }

    public function test_all()
    {
        $driver = new ArrayDriver([
            'a' => ['b', 'c']
        ]);

        $this->assertEquals([
            'a' => ['b', 'c']
        ], $driver->all());

        $this->assertEquals([
            'b', 'c'
        ], $driver->all('a'));
    }
}
