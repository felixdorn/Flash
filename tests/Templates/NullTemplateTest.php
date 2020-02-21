<?php


namespace Felix\Tests\Flash\Templates;


use Felix\Flash\Templates\NullTemplate;
use Felix\Tests\Flash\TestCase;

class NullTemplateTest extends TestCase
{

    public function test_toHtml() {
        $template = new NullTemplate();

        $this->assertEquals(
            '',
            $template->toHtml('some', 'thing')
        );
    }

}
