<?php

namespace Felix\Tests\Flash;

use Felix\Flash\FlashData;

class FlashDataTest extends TestCase
{
    public function test_get_type()
    {
        $data = new FlashData('theType', 'theMessage');

        $this->assertEquals(
            'theType',
            $data->getType()
        );
    }

    public function test_get_message()
    {
        $data = new FlashData('theType', 'theMessage');

        $this->assertEquals(
            'theMessage',
            $data->getMessage()
        );
    }
}
