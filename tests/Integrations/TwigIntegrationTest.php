<?php

namespace Felix\Tests\Flash\Integrations;

use Felix\Flash\Integrations\Twig\FlashExtension;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class TwigIntegrationTest extends TestCase
{
    /**
     * @var Environment
     */
    private $twig;

    public function testItOutputOnlyATypeInTwig()
    {
        flash()->clear();

        flash('success', 'Hello world!');

        $output = $this->twig->render('only_success');

        $this->assertEquals(
            'Hello world!',
            $output
        );
    }

    public function testItOutputAllFlashInTwig()
    {
        flash()->clear();

        flash('success', 'Hello world!');

        $output = $this->twig->render('all_flashes');

        $this->assertEquals(
            'Hello world!',
            $output
        );
    }

    protected function setUp(): void
    {
        $loader = new ArrayLoader([
            'all_flashes' => <<<TWIG
{{ flash() }}
TWIG, 'only_success' => <<<TWIG
{{ flash('success') }}
TWIG
        ]);
        $this->twig = new Environment($loader, []);
        $this->twig->addExtension(new FlashExtension());
    }
}
