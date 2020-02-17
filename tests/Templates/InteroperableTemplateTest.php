<?php


namespace Felix\Tests\Flash\Templates;

use Felix\Flash\Templates\InteroperableTemplate;
use Felix\Flash\Templates\TemplateInterface;
use Felix\Tests\Flash\TestCase;

class InteroperableTemplateTest extends TestCase
{
    public function test_convert_to_html_with_template_interface()
    {
        $template = new InteroperableTemplate(new class implements TemplateInterface {
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

    public function test_convert_to_html_with_string_template()
    {
        $template = new InteroperableTemplate('{type}: {value}');

        $this->assertEquals(
            'theType: theMessage',
            $template->toHtml('theType', 'theMessage')
        );
    }

    public function test__convert_to_html_with_callable()
    {
        $template = new InteroperableTemplate(function (string $type, string $message): string {
            return sprintf('%s: %s', $type, $message);
        });

        $this->assertEquals(
            'theType: theMessage',
            $template->toHtml('theType', 'theMessage')
        );
    }

    public function test_can_not_convert_to_html_with_anything_else()
    {
        $this->expectException(\InvalidArgumentException::class);

        $template = new InteroperableTemplate(['a' => 'b']);

        $template->toHtml('theType', 'theValue');
    }
}
