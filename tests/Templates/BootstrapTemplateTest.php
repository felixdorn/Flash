<?php

namespace Felix\Tests\Flash\Templates;

use Felix\Flash\Templates\BootstrapTemplate;
use Felix\Tests\Flash\TestCase;

class BootstrapTemplateTest extends TestCase
{
    public function testToHtml()
    {
        $template = new BootstrapTemplate();

        $this->assertEquals(
            '<div class="alert alert-theType mt-4" role="alert">theMessage</div>',
            $template->toHtml('theType', 'theMessage')
        );

        $this->assertEquals(
            '<div class="alert alert-theOtherType mt-4" role="alert">theOtherMessage</div>',
            $template->toHtml('theOtherType', 'theOtherMessage')
        );
    }
}
