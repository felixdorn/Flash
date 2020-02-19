<?php


namespace Felix\Flash;

/**
 * Class FunctionalFlash
 * @package Felix\Flash
 * @internal
 */
class FunctionalFlash
{
    /**
     * @var null|FunctionalFlash
     */
    private static $uniqueInstance = null;
    /**
     * @var Flash
     */
    private $flash = null;

    /**
     * @return FunctionalFlash
     */
    public static function getInstance(): FunctionalFlash
    {
        if (self::$uniqueInstance === null) {
            self::$uniqueInstance = new self;
        }

        return self::$uniqueInstance;
    }

    /**
     * @return Flash|null
     */
    public function getFlash(): ?Flash
    {
        return $this->flash;
    }

    /**
     * @param Flash $flash
     * @return FunctionalFlash
     */
    public function setFlash(Flash $flash): FunctionalFlash
    {
        $this->flash = $flash;
        return $this;
    }
}
