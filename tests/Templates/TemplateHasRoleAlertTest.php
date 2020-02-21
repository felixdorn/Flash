<?php


namespace Felix\Tests\Flash\Templates;

use Felix\Flash\Templates\BootstrapTemplate;
use Felix\Flash\Templates\BulmaTemplate;
use Felix\Flash\Templates\Semantic2Template;
use Felix\Flash\Templates\SpectreTemplate;
use Felix\Flash\Templates\TemplateInterface;
use Felix\Tests\Flash\TestCase;

class TemplateHasRoleAlertTest extends TestCase
{

    public function test_html_based_alerts_have_role_alert()
    {
        $templates = [
            BootstrapTemplate::class,
            BulmaTemplate::class,
            Semantic2Template::class,
            SpectreTemplate::class
        ];

        /** @var TemplateInterface $template */
        foreach ($templates as $template) {
            $template = new $template;

            $this->assertStringContainsString(
                'role="alert"',
                $template->toHtml('theType', 'theMessage')
            );
        }
    }
}
