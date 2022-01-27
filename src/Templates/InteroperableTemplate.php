<?php

namespace Felix\Flash\Templates;

final class InteroperableTemplate
{
    /**
     * @var TemplateInterface|callable|string|InteroperableTemplate
     */
    private $template;

    /**
     * @param TemplateInterface|callable|string|InteroperableTemplate $template
     */
    public function __construct($template)
    {
        $this->template = $template;
    }

    public function toHtml(string $type, string $flash): string
    {
        if ($this->template instanceof TemplateInterface ||
            $this->template instanceof InteroperableTemplate
        ) {
            return $this->template->toHtml($type, $flash);
        }

        if (is_callable($this->template)) {
            $cb = $this->template;

            return $cb($type, $flash);
        }

        if (is_string($this->template)) {
            // So something with <div class="alert alert-{type}">{value}</div> will produce
            // <div class="alert alert-error>Stop!</div> if $type == error and $flash == Stop!
            $withType = str_replace('{type}', $type, $this->template);

            // Here we support both flash and value.
            $withValue = str_replace('{flash}', $flash, $withType);

            return str_replace('{value}', $flash, $withValue);
        }

        throw new \InvalidArgumentException('Can not convert template of type ' . gettype($this->template));
    }
}
