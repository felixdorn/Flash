<?php


namespace Felix\Tests\Flash\Templates;

use Felix\Flash\Templates\BootstrapTemplate;
use Felix\Flash\Templates\BulmaTemplate;
use Felix\Tests\Flash\TestCase;

class BulmaTemplateTest extends TestCase
{
    public function test_to_html()
    {
        $template = new BulmaTemplate();

        $this->assertEquals(
            '<div class="notification is-theType mt-4" role="alert">theMessage</div>',
            $template->toHtml('theType', 'theMessage')
        );

        $this->assertEquals(
            '<div class="notification is-theOtherType mt-4" role="alert">theOtherMessage</div>',
            $template->toHtml('theOtherType', 'theOtherMessage')
        );
    }
}
