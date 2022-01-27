<?php

namespace Felix\Tests\Flash\Templates;

use Felix\Flash\Templates\InteroperableTemplate;
use Felix\Flash\Templates\TemplateInterface;
use Felix\Tests\Flash\TestCase;

class InteroperableTemplateTest extends TestCase
{
    public function testConvertToHtmlWithTemplateInterface()
    {
        $template = new InteroperableTemplate(new class() implements TemplateInterface {
            public function toHtml(string $type, string $message)
            {
                return sprintf('%s: %s', $type, $message);
            }
        });

        $this->assertEquals(
            'theType: theMessage',
            $template->toHtml('theType', 'theMessage')
        );
    }

    public function testConvertToHtmlWithStringTemplate()
    {
        $template = new InteroperableTemplate('{type}: {value}');

        $this->assertEquals(
            'theType: theMessage',
            $template->toHtml('theType', 'theMessage')
        );
    }

    public function testConvertToHtmlWithCallable()
    {
        $template = new InteroperableTemplate(function (string $type, string $message): string {
            return sprintf('%s: %s', $type, $message);
        });

        $this->assertEquals(
            'theType: theMessage',
            $template->toHtml('theType', 'theMessage')
        );
    }
}
