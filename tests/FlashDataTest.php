<?php

namespace Felix\Tests\Flash;

use Felix\Flash\FlashData;

class FlashDataTest extends TestCase
{
    public function testGetType()
    {
        $data = new FlashData('theType', 'theMessage');

        $this->assertEquals(
            'theType',
            $data->getType()
        );
    }

    public function testGetMessage()
    {
        $data = new FlashData('theType', 'theMessage');

        $this->assertEquals(
            'theMessage',
            $data->getMessage()
        );
    }
}
