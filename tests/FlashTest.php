<?php

namespace Felix\Tests\Flash;

use Felix\Flash\Drivers\ArrayDriver;
use Felix\Flash\Drivers\SessionDriver;
use Felix\Flash\Flash;
use Felix\Flash\Templates\InteroperableTemplate;
use Felix\Flash\Templates\TestableTemplate;

class FlashTest extends TestCase
{
    public function testSuccessMethodFlashCalled()
    {
        $flash = $this->createPartialMock(Flash::class, ['flash']);
        $flash->expects(
            $this->once()
        )->method('flash')->with('success', 'Hello world!');
        $flash->success('Hello world!');
    }

    public function testSuccessMethodAddFlashToDriver()
    {
        $this->flash->success('Hello world!');

        $this->assertEquals(
            [
                'success' => [
                    'Hello world!',
                ],
            ],
            $this->flash->getDriver()->all()
        );
    }

    public function testErrorMethodFlashCalled()
    {
        $flash = $this->createPartialMock(Flash::class, ['flash']);
        $flash->expects(
            $this->once()
        )->method('flash')->with('error', 'Hello world!');
        $flash->error('Hello world!');
    }

    public function testErrorMethodAddFlashToDriver()
    {
        $this->flash->error('Hello world!');

        $this->assertEquals(
            [
                'error' => [
                    'Hello world!',
                ],
            ],
            $this->flash->getDriver()->all()
        );
    }

    public function testWarningMethodFlashCalled()
    {
        $flash = $this->createPartialMock(Flash::class, ['flash']);
        $flash->expects(
            $this->once()
        )->method('flash')->with('warning', 'Hello world!');
        $flash->warning('Hello world!');
    }

    public function testWarningMethodAddFlashToDriver()
    {
        $this->flash->warning('Hello world!');

        $this->assertEquals(
            [
                'warning' => [
                    'Hello world!',
                ],
            ],
            $this->flash->getDriver()->all()
        );
    }

    public function testInfoMethodFlashCalled()
    {
        $flash = $this->createPartialMock(Flash::class, ['flash']);
        $flash->expects(
            $this->once()
        )->method('flash')->with('info', 'Hello world!');
        $flash->info('Hello world!');
    }

    public function testInfoMethodAddFlashToDriver()
    {
        $this->flash->info('Hello world!');

        $this->assertEquals(
            [
                'info' => [
                    'Hello world!',
                ],
            ],
            $this->flash->getDriver()->all()
        );
    }

    public function testSetAndGetTemplate()
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

    public function testClearFlashes()
    {
        $driver = $this->createMock(SessionDriver::class);

        $driver->expects(
            $this->once()
        )->method('clear')->willReturnSelf();

        $this->flash->setDriver($driver);

        $this->flash->clear();
    }

    public function testRenderAll()
    {
        $driver = $this->createMock(SessionDriver::class);
        $driver->expects(
            $this->once()
        )->method('all')->willReturn([
            'success' => [
                'Hello world!',
            ],
            'error' => [
                'Mad world!',
            ],
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

    public function testRenderAllWithSpecificType()
    {
        $driver = $this->createMock(ArrayDriver::class);
        $driver->expects(
            $this->once()
        )->method('all')->with('success')->willReturn([
            'Hello world!',
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

    public function testRenderAllWithNonExistingType()
    {
        $driver = $this->createMock(ArrayDriver::class);
        $driver->expects(
            $this->once()
        )->method('all')->willReturn([]);

        $this->flash->setDriver($driver);

        $this->assertEquals('', $this->flash->render('nonExistingType'));
    }

    public function testFlashWithCustomTypes()
    {
        $this->flash->flash('customType', 'theMessage');

        $this->assertEquals([
            'customType' => [
                'theMessage',
            ],
        ], $this->flash->getDriver()->all());
    }

    public function testClearWithCustomTypes()
    {
        $this->flash->flash('customType', 'theMessage');

        $this->assertEquals([
            'customType' => [
                'theMessage',
            ],
        ], $this->flash->getDriver()->all());

        $this->flash->clear();

        $this->assertEquals([], $this->flash->getDriver()->all());
    }

    public function testSetTemplateFromConstructor()
    {
        $flash = new Flash($this->driver, '{type} {flash}');

        $this->assertEquals(
            new InteroperableTemplate('{type} {flash}'),
            $flash->getTemplate()
        );
    }

    public function testFlashAreNotAddedWhenDisabled()
    {
        $this->flash->disable();

        $this->flash->warning('Hello world!');

        $this->assertEquals(
            [],
            $this->flash->getDriver()->all()
        );
    }

    public function testEnableFlashAfterDisablingThem()
    {
        $this->flash->disable();
        $this->flash->enable();

        $this->flash->warning('Hello world!');

        $this->assertEquals(
            [
                'warning' => [
                    'Hello world!',
                ],
            ],
            $this->flash->getDriver()->all()
        );
    }
}
