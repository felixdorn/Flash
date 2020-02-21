<?php


namespace Felix\Flash;

/**
 * @internal
 */
class FlashData
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $message;

    /**
     * @param string $type
     * @param string $message
     */
    public function __construct(string $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
