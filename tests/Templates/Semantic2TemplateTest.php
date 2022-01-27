<?php

namespace Felix\Tests\Flash\Templates;

use Felix\Flash\Templates\Semantic2Template;
use Felix\Tests\Flash\TestCase;

class Semantic2TemplateTest extends TestCase
{
    public function testToHtml()
    {
        $template = new Semantic2Template();

        $this->assertEquals(
            '<div class="ui message theType" role="alert">theMessage</div>',
            $template->toHtml('theType', 'theMessage')
        );

        $this->assertEquals(
            '<div class="ui message theOtherType" role="alert">theOtherMessage</div>',
            $template->toHtml('theOtherType', 'theOtherMessage')
        );
    }
}
