<?php


use Felix\Flash\Flash;
use Felix\Flash\FunctionalFlash;

/**
 * @param string|null $type
 * @param string|null $message
 * @return Flash
 * @codeCoverageIgnore Even if this function is tested
 * @see \Felix\Tests\Flash\FunctionalFlashTest::test_flash_function()
 */
function flash(string $type = null, ?string $message = null): Flash
{
    $manager = FunctionalFlash::getInstance()->getFlash();

    if ($manager === null) {
        throw new RuntimeException(
            sprintf(
                'Trying to flash `%s` using the flash() function but Flash is not initialised',
                $message
            )
        );
    }

    if (!is_string($type) || !is_string($message)) {
        return $manager;
    }

    return $manager->flash($type, $message);
}
