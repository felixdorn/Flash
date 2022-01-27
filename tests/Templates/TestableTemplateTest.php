<?php

namespace Felix\Tests\Flash\Templates;

use Felix\Flash\Templates\TestableTemplate;
use Felix\Tests\Flash\TestCase;

class TestableTemplateTest extends TestCase
{
    public function testToHtml()
    {
        $template = new TestableTemplate();

        $this->assertEquals(
            'theType theMessage',
            $template->toHtml('theType', 'theMessage')
        );

        $this->assertEquals(
            'theOtherType theOtherMessage',
            $template->toHtml('theOtherType', 'theOtherMessage')
        );
    }
}
