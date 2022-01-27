<?php

namespace Felix\Flash\Drivers;

use Felix\Flash\FlashData;

interface DriverInterface
{
    public function clear(): self;

    public function push(FlashData $data): self;

    public function all(string $type = 'all'): array;
}
