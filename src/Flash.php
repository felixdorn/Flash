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
     * @param DriverInterface $driver
     * @param TemplateInterface|callable|string|InteroperableTemplate $template
     */
    public function __construct(DriverInterface $driver, $template)
    {
        $this->driver = $driver;
        $this->template = new InteroperableTemplate($template);
        $this->disabled = false;

        // We initialize the FunctionFlash so flash() function will work
        FunctionalFlash::getInstance()->setFlash($this);
    }


    /**
     * @param string $message
     * @return $this
     */
    public function success(string $message): Flash
    {
        $this->flash('success', $message);

        return $this;
    }

    /**
     * @param string $type
     * @param string $message
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
     * @param string $message
     * @return $this
     */
    public function error(string $message): Flash
    {
        $this->flash('error', $message);

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function warning(string $message): Flash
    {
        $this->flash('warning', $message);

        return $this;
    }

    /**
     * @return DriverInterface
     */
    public function getDriver(): DriverInterface
    {
        return $this->driver;
    }

    /**
     * @param DriverInterface $driver
     * @return Flash
     */
    public function setDriver(DriverInterface $driver): Flash
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * @param string $message
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

    /**
     * @return InteroperableTemplate
     */
    public function getTemplate(): InteroperableTemplate
    {
        return $this->template;
    }

    /**
     * @param TemplateInterface|callable|string|InteroperableTemplate $template
     * @return Flash
     */
    public function setTemplate($template): Flash
    {
        $this->template = new InteroperableTemplate($template);

        return $this;
    }

    public function render(string $type = 'all'): string
    {
        $flashes = $this->driver->all($type);
        $buffer = '';

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

    /**
     * @return Flash
     */
    public function disable(): Flash
    {
        $this->disabled = true;

        return $this;
    }

    /**
     * @return Flash
     */
    public function enable(): Flash
    {
        $this->disabled = false;

        return $this;
    }
}
