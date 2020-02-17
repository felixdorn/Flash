<?php


namespace Felix\Flash\Drivers;

use Felix\Flash\FlashData;

interface DriverInterface
{
    /**
     * @return DriverInterface
     */
    public function clear(): self;

    /**
     * @param FlashData $data
     * @return DriverInterface
     */
    public function push(FlashData $data): self;

    /**
     * @param string $type
     * Here the real return type is array<int, string>[]|string[] but phpstan does not understand that
     * @return mixed[]
     */
    public function all(string $type = 'all'): array;
}
