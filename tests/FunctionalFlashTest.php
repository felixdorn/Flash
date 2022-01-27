<?php

namespace Felix\Tests\Flash;

use Felix\Flash\FunctionalFlash;

class FunctionalFlashTest extends TestCase
{
    public function testGetSet()
    {
        $flash = new FunctionalFlash();
        $flash->setFlash($this->flash);

        $this->assertEquals(
            $this->flash,
            $flash->getFlash()
        );
    }

    public function testFlashFunction()
    {
        // Function flash is registered by the setUp parent method
        $flash = FunctionalFlash::getInstance()->getFlash();

        $this->assertEquals(
            $this->flash,
            $flash
        );

        /* Assert flash function returns self when no arguments are passed */
        $this->assertEquals(
            $this->flash,
            flash()
        );

        /* Assert return self when arguments are passed */
        $this->assertEquals(
            $this->flash,
            flash('error', 'Mad world.')
        );

        $this->assertEquals(
            [
                'error' => [
                    'Mad world.',
                ],
            ], $this->flash->getDriver()->all()
        );
    }
}
