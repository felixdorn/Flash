<?php
/**
 * This file is part of Flash.
 *
 * Flash is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Flash is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Flash.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace Felix\Tests\Flash;


use Felix\Flash\Flasher;
use Felix\Flash\TemplateInterface;
use Felix\Flash\Templates\BulmaTemplate;
use Felix\Flash\Templates\DefaultTemplate;
use PHPUnit\Framework\TestCase;

class FlasherTest extends TestCase
{
    /**
     * @var array
     */
    private $session;
    /**
     * @var Flasher
     */
    private $flasher;

    /**
     * @covers \Felix\Flash\Flasher::message()
     */
    public function testMessage()
    {
        $this->flasher->message('message', 'error');

        $this->assertEquals(
            '<section class="alert alert-error">message</section>',
            $this->session[Flasher::ARRAY_KEY]['error'][0]
        );

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flasher::getInstance()
     * @covers \Felix\Flash\Flasher::__construct
     */
    public function testGetInstance()
    {
        // Reset flasher
        $flasher = new Flasher();

        // First time to trigger the singleton
        $this->assertInstanceOf(Flasher::class, $flasher::getInstance());

        // Second time to get the singleton
        $this->assertInstanceOf(Flasher::class, $flasher::getInstance());

        $this->setUp();
    }

    protected function setUp(): void
    {
        $this->session = [];
        $this->flasher = Flasher::getInstance()->setStorer($this->session);
    }

    /**
     * @covers \Felix\Flash\Flasher::setStorer()
     */
    public function testSetStorer()
    {
        $session = ['a' => 'b'];
        $flasher = new Flasher();

        $flasher->setStorer($session);

        $reflection = new \ReflectionClass(Flasher::class);
        $property = $reflection->getProperty('storer');
        $property->setAccessible(true);

        $this->assertEquals(['a' => 'b'], $property->getValue($flasher));

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flasher::pushTemplate()
     */
    public function testPushTemplate()
    {
        $this->flasher->pushTemplate(new BulmaTemplate());

        $this->flasher->error('error');

        $output = $this->flasher->display();

        $this->assertEquals('<section class="notification is-error">error</section>', $output);

        $this->flasher->clear();
        $this->flasher->pushTemplate(new DefaultTemplate());
    }

    /**
     * @covers \Felix\Flash\Flasher::error()
     */
    public function testError()
    {
        $this->flasher->error('error');

        $output = $this->flasher->display();

        $this->assertEquals('<section class="alert alert-error">error</section>', $output);

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flasher::warning()
     */
    public function testWarning()
    {
        $this->flasher->warning('warning');

        $output = $this->flasher->display();

        $this->assertEquals('<section class="alert alert-warning">warning</section>', $output);

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flasher::success()
     */
    public function testSuccess()
    {
        $this->flasher->success('success');

        $output = $this->flasher->display();

        $this->assertEquals('<section class="alert alert-success">success</section>', $output);

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flasher::info()
     */
    public function testInfo()
    {
        $this->flasher->info('info');

        $output = $this->flasher->display();

        $this->assertEquals('<section class="alert alert-info">info</section>', $output);

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flasher::getTemplate()
     */
    public function testGetTemplate()
    {
        $template = $this->flasher->getTemplate();

        $this->assertInstanceOf(TemplateInterface::class, $template);
    }

    /**
     * @covers \Felix\Flash\Flasher::register()
     */
    public function testRegister()
    {
        $this->flasher->register('output', 'error');

        $reflection = new \ReflectionClass(Flasher::class);
        $storer = $reflection->getProperty('storer');
        $storer->setAccessible(true);
        $storer = $storer->getValue($this->flasher);

        $this->assertEquals('output', $storer[Flasher::ARRAY_KEY]['error'][0]);

        $this->flasher->clear();
    }

    public function testDisplay()
    {
        $this->flasher->info('that info');

        $output = $this->flasher->display();

        $this->assertEquals('<section class="alert alert-info">that info</section>', $output);

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flasher::display
     */
    public function testDisplayWhenNoFlash()
    {
        $this->flasher->clear();

        $output = $this->flasher->display();

        $this->assertEmpty($output);
    }

    /**
     * @covers \Felix\Flash\Flasher::display
     */
    public function testDisplayWhenTypeDoNotExists()
    {
        $this->flasher->success('some success');

        $output = $this->flasher->display('unexisting type');

        $this->assertEmpty($output);

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flasher::display
     */
    public function testDisplayWhenTypeExists()
    {
        $this->flasher->warning('some warning');

        $output = $this->flasher->display('warning');

        $this->assertEquals('<section class="alert alert-warning">some warning</section>', $output);

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flasher::handleStorer
     */
    public function testHandleStorer()
    {
        $flasher = new Flasher();

        $flasher->warning('warning');

        $reflection = new \ReflectionClass(Flasher::class);
        $storer = $reflection->getProperty('storer');
        $storer->setAccessible(true);
        $storer = $storer->getValue($flasher);

        $this->assertArrayNotHasKey('warning', $storer[Flasher::ARRAY_KEY]);
    }
}