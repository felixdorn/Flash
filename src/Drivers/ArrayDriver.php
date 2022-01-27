<?php

namespace Felix\Flash\Drivers;

use Felix\Flash\FlashData;

class ArrayDriver implements DriverInterface
{
    /**
     * @var mixed[]
     */
    private $buffer;

    /**
     * ArrayDriver constructor.
     *
     * @param mixed[] $buffer
     */
    public function __construct(array $buffer)
    {
        $this->buffer = $buffer;
    }

    /**
     * {@inheritDoc}
     */
    public function clear(): DriverInterface
    {
        $this->buffer = [];

        return $this;
    }

    public function push(FlashData $data): DriverInterface
    {
        if (!array_key_exists($data->getType(), $this->buffer)) {
            $this->buffer[$data->getType()] = [];
        }

        $this->buffer[$data->getType()][] = $data->getMessage();

        return $this;
    }

    /**
     * @return mixed[]
     */
    public function all(string $type = 'all'): array
    {
        if ($type === 'all') {
            return $this->buffer;
        }

        return array_key_exists($type, $this->buffer) ? $this->buffer[$type] : [];
    }
}
