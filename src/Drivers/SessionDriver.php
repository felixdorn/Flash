<?php

namespace Felix\Flash\Drivers;

use Felix\Flash\FlashData;

class SessionDriver implements DriverInterface
{
    /**
     * @var mixed[]
     */
    private $sessionOption;

    /**
     * @var mixed[]
     */
    private $session;

    /**
     * SessionDriver constructor.
     * @param mixed[] $sessionOption
     * @param mixed[] $session
     */
    public function __construct(array $sessionOption = [], array $session = [])
    {
        $this->sessionOption = $sessionOption;
        $this->session = $session;
    }

    /**
     * @codeCoverageIgnore
     */
    private function ensureSessionStarted(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE && empty($this->session)) {
            session_start($this->sessionOption);
            $this->session = &$_SESSION;

            return;
        }

        if (empty($this->session) || !array_key_exists('flash', $this->session)) {
            $this->session = [
                'flash' => []
            ];
        }
    }

    /**
     * @return DriverInterface
     */
    public function clear(): DriverInterface
    {
        $this->ensureSessionStarted();

        $this->session['flash'] = [];

        return $this;
    }

    /**
     * @param FlashData $data
     * @return DriverInterface
     */
    public function push(FlashData $data): DriverInterface
    {
        $this->ensureSessionStarted();

        if (!array_key_exists($data->getType(), $this->session['flash'])) {
            $this->session['flash'][$data->getType()] = [];
        }

        $this->session['flash'][$data->getType()][] = $data->getMessage();

        return $this;
    }

    /**
     * @param string $type
     * @return mixed[]
     */
    public function all(string $type = 'all'): array
    {
        $this->ensureSessionStarted();

        if ($type === 'all') {
            return $this->session['flash'];
        }


        if (array_key_exists($type, $this->session['flash'])) {
            return $this->session['flash'][$type];
        }

        return [];
    }
}
