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

    public function __construct(string $type, string $message)
    {
        $this->type    = $type;
        $this->message = $message;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
