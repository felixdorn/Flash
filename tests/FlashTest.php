<?php


namespace Felix\Tests\Flash;

use Felix\Flash\Drivers\ArrayDriver;
use Felix\Flash\Drivers\SessionDriver;
use Felix\Flash\Flash;
use Felix\Flash\Templates\InteroperableTemplate;
use Felix\Flash\Templates\TestableTemplate;

class FlashTest extends TestCase
{
    public function test_success_method_flash_called()
    {
        $flash = $this->createPartialMock(Flash::class, ['flash']);
        $flash->expects(
            $this->once()
        )->method('flash')->with('success', 'Hello world!');
        $flash->success('Hello world!');
    }

    public function test_success_method_add_flash_to_driver()
    {
        $this->flash->success('Hello world!');

        $this->assertEquals(
            [
                'success' => [
                    'Hello world!'
                ]
            ],
            $this->flash->getDriver()->all()
        );
    }

    public function test_error_method_flash_called()
    {
        $flash = $this->createPartialMock(Flash::class, ['flash']);
        $flash->expects(
            $this->once()
        )->method('flash')->with('error', 'Hello world!');
        $flash->error('Hello world!');
    }

    public function test_error_method_add_flash_to_driver()
    {
        $this->flash->error('Hello world!');

        $this->assertEquals(
            [
                'error' => [
                    'Hello world!'
                ]
            ],
            $this->flash->getDriver()->all()
        );
    }

    public function test_warning_method_flash_called()
    {
        $flash = $this->createPartialMock(Flash::class, ['flash']);
        $flash->expects(
            $this->once()
        )->method('flash')->with('warning', 'Hello world!');
        $flash->warning('Hello world!');
    }

    public function test_warning_method_add_flash_to_driver()
    {
        $this->flash->warning('Hello world!');

        $this->assertEquals(
            [
                'warning' => [
                    'Hello world!'
                ]
            ],
            $this->flash->getDriver()->all()
        );
    }

    public function test_info_method_flash_called()
    {
        $flash = $this->createPartialMock(Flash::class, ['flash']);
        $flash->expects(
            $this->once()
        )->method('flash')->with('info', 'Hello world!');
        $flash->info('Hello world!');
    }

    public function test_info_method_add_flash_to_driver()
    {
        $this->flash->info('Hello world!');

        $this->assertEquals(
            [
                'info' => [
                    'Hello world!'
                ]
            ],
            $this->flash->getDriver()->all()
        );
    }

    public function test_set_and_get_template()
    {
        $this->flash->setTemplate(
            'Hello world!'
        );

        $this->assertEquals(
            new InteroperableTemplate(
                'Hello world!'
            ),
            $this->flash->getTemplate()
        );
    }

    public function test_clear_flashes()
    {
        $driver = $this->createMock(SessionDriver::class);

        $driver->expects(
            $this->once()
        )->method('clear')->willReturnSelf();

        $this->flash->setDriver($driver);

        $this->flash->clear();
    }

    public function test_render_all()
    {
        $driver = $this->createMock(SessionDriver::class);
        $driver->expects(
            $this->once()
        )->method('all')->willReturn([
            'success' => [
                'Hello world!'
            ],
            'error' => [
                'Mad world!'
            ]
        ]);

        $template = $this->createMock(TestableTemplate::class);
        $template->expects(
            $this->exactly(2)
        )->method('toHtml')->withAnyParameters()->willReturn('content');


        $this->flash->setDriver($driver);
        $this->flash->setTemplate($template);

        $output = $this->flash->render();

        $this->assertEquals('contentcontent', $output);
    }

    public function test_render_all_with_specific_type()
    {
        $driver = $this->createMock(ArrayDriver::class);
        $driver->expects(
            $this->once()
        )->method('all')->with('success')->willReturn([
            'Hello world!'
        ]);

        $template = $this->createMock(TestableTemplate::class);
        $template->expects(
            $this->once()
        )->method('toHtml')->withAnyParameters()->willReturn('content');


        $this->flash->setDriver($driver);
        $this->flash->setTemplate($template);

        $output = $this->flash->render('success');

        $this->assertEquals('content', $output);
    }

    public function test_render_all_with_non_existing_type()
    {
        $driver = $this->createMock(ArrayDriver::class);
        $driver->expects(
            $this->once()
        )->method('all')->willReturn([]);

        $this->flash->setDriver($driver);

        $this->assertEquals('', $this->flash->render('nonExistingType'));
    }

    public function test_flash_with_custom_types()
    {
        $this->flash->flash('customType', 'theMessage');

        $this->assertEquals([
            'customType' => [
                'theMessage'
            ]
        ], $this->flash->getDriver()->all());
    }

    public function test_clear_with_custom_types()
    {
        $this->flash->flash('customType', 'theMessage');

        $this->assertEquals([
            'customType' => [
                'theMessage'
            ]
        ], $this->flash->getDriver()->all());

        $this->flash->clear();

        $this->assertEquals([], $this->flash->getDriver()->all());

    }

    public function test_set_template_from_constructor()
    {
        $flash = new Flash($this->driver, '{type} {flash}');

        $this->assertEquals(
            new InteroperableTemplate('{type} {flash}'),
            $flash->getTemplate()
        );
    }

    public function test_flash_are_not_added_when_disabled()
    {
        $this->flash->disable();

        $this->flash->warning('Hello world!');

        $this->assertEquals(
            [],
            $this->flash->getDriver()->all()
        );

    }


    public function test_enable_flash_after_disabling_them()
    {
        $this->flash->disable();
        $this->flash->enable();

        $this->flash->warning('Hello world!');

        $this->assertEquals(
            [
                'warning' => [
                    'Hello world!'
                ]
            ],
            $this->flash->getDriver()->all()
        );

    }
}
