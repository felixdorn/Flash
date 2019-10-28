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


use Felix\Flash\Flash;
use Felix\Flash\Flasher;
use PHPUnit\Framework\TestCase;

class FlashTest extends TestCase
{
    /**
     * @var Flasher
     */
    private $flasher;
    /**
     * @var array
     */
    private $session;


    /**
     * @covers \Felix\Flash\Flash::message()
     */
    public function testMessage()
    {
        $this->flasher->message('message', 'error');

        $this->assertEquals(
            '<section class="alert alert-error">message</section>',
            $this->session['error'][0]
        );

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flash::error()
     */
    public function testError()
    {
        $this->flasher->error('error');

        $output = $this->flasher->display();

        $this->assertEquals('<section class="alert alert-error">error</section>', $output);

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flash::warning()
     */
    public function testWarning()
    {
        $this->flasher->warning('warning');

        $output = $this->flasher->display();

        $this->assertEquals('<section class="alert alert-warning">warning</section>', $output);

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flash::success()
     */
    public function testSuccess()
    {
        $this->flasher->success('success');

        $output = $this->flasher->display();

        $this->assertEquals('<section class="alert alert-success">success</section>', $output);

        $this->flasher->clear();
    }

    /**
     * @covers \Felix\Flash\Flash::info()
     */
    public function testInfo()
    {
        $this->flasher->info('info');

        $output = $this->flasher->display();

        $this->assertEquals('<section class="alert alert-info">info</section>', $output);

        $this->flasher->clear();
    }

    public function testNormalizeContentWithArray()
    {
        $reflection = new \ReflectionClass(Flash::class);
        $method = $reflection->getMethod('normalizeContent');
        $method->setAccessible(true);
        $args = ['warning1', 'warning2'];
        $res = $method->invokeArgs(new Flash(), [$args]);

        $this->assertEquals(['warning1', 'warning2'], explode(PHP_EOL, $res));

        $this->flasher->clear();

    }

    protected function setUp(): void
    {
        $this->session = [];
        $this->flasher = Flasher::getInstance()->setStorer($this->session);
    }
}
