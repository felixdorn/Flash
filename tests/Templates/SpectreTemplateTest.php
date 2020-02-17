<?php


namespace Felix\Tests\Flash\Templates;


use Felix\Flash\Templates\SpectreTemplate;
use Felix\Tests\Flash\TestCase;

class SpectreTemplateTest extends TestCase
{
    public function test_toHtml()
    {
        $template = new SpectreTemplate();

        $this->assertEquals(
            '<div class="toast toast-theType" role="alert">theMessage</div>',
            $template->toHtml('theType', 'theMessage')
        );

        $this->assertEquals(
            '<div class="toast toast-theOtherType" role="alert">theOtherMessage</div>',
            $template->toHtml('theOtherType', 'theOtherMessage')
        );
    }
}