<?php

namespace Felix\Flash;

/**
 * Class FunctionalFlash.
 *
 * @internal
 */
class FunctionalFlash
{
    /**
     * @var FunctionalFlash|null
     */
    private static $uniqueInstance = null;
    /**
     * @var Flash
     */
    private $flash = null;

    public static function getInstance(): FunctionalFlash
    {
        if (self::$uniqueInstance === null) {
            self::$uniqueInstance = new self();
        }

        return self::$uniqueInstance;
    }

    public function getFlash(): ?Flash
    {
        return $this->flash;
    }

    public function setFlash(Flash $flash): FunctionalFlash
    {
        $this->flash = $flash;

        return $this;
    }
}
