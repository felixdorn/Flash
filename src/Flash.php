<?php

namespace Felix\Flash;

use Felix\Flash\Drivers\DriverInterface;
use Felix\Flash\Templates\InteroperableTemplate;
use Felix\Flash\Templates\TemplateInterface;

class Flash
{
    /**
     * @var DriverInterface
     */
    private $driver;
    /**
     * @var InteroperableTemplate
     */
    private $template;
    /**
     * @var bool
     */
    private $disabled;

    /**
     * @param TemplateInterface|callable|string|InteroperableTemplate $template
     */
    public function __construct(DriverInterface $driver, $template)
    {
        $this->driver   = $driver;
        $this->template = new InteroperableTemplate($template);
        $this->disabled = false;
    }

    /**
     * @return $this
     */
    public function success(string $message): Flash
    {
        $this->flash('success', $message);

        return $this;
    }

    /**
     * @return $this
     */
    public function flash(string $type, string $message): Flash
    {
        if ($this->disabled) {
            return $this;
        }

        $this->driver->push(
            new FlashData($type, $message)
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function error(string $message): Flash
    {
        $this->flash('error', $message);

        return $this;
    }

    /**
     * @return $this
     */
    public function warning(string $message): Flash
    {
        $this->flash('warning', $message);

        return $this;
    }

    public function getDriver(): DriverInterface
    {
        return $this->driver;
    }

    public function setDriver(DriverInterface $driver): Flash
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return $this
     */
    public function info(string $message): Flash
    {
        $this->flash('info', $message);

        return $this;
    }

    public function clear(): self
    {
        $this->driver->clear();

        return $this;
    }

    public function getTemplate(): InteroperableTemplate
    {
        return $this->template;
    }

    /**
     * @param TemplateInterface|callable|string|InteroperableTemplate $template
     */
    public function setTemplate($template): Flash
    {
        $this->template = new InteroperableTemplate($template);

        return $this;
    }

    public function render(string $type = 'all'): string
    {
        $flashes = $this->driver->all($type);
        $buffer  = '';

        if ($type === 'all') {
            foreach ($flashes as $flashTypes) {
                foreach ($flashTypes as $type => $flash) {
                    $buffer .= $this->template->toHtml($type, $flash);
                }
            }

            return $buffer;
        }

        foreach ($flashes as $type => $flash) {
            $buffer .= $this->template->toHtml($type, $flash);
        }

        return $buffer;
    }

    public function disable(): Flash
    {
        $this->disabled = true;

        return $this;
    }

    public function enable(): Flash
    {
        $this->disabled = false;

        return $this;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function isEnabled(): bool
    {
        return !$this->disabled;
    }
}
