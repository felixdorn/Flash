<?php

namespace Felix\Flash\Templates;

final class InteroperableTemplate
{
    /**
     * @var TemplateInterface|callable|string|InteroperableTemplate
     */
    private $template;

    public function __construct(TemplateInterface|callable|string|InteroperableTemplate $template)
    {
        $this->template = $template;
    }

    public function toHtml(string $type, string $flash): string
    {
        if (
            $this->template instanceof TemplateInterface ||
            $this->template instanceof InteroperableTemplate
        ) {
            return $this->template->toHtml($type, $flash);
        }

        if (is_callable($this->template)) {
            return ($this->template)($type, $flash);
        }

        if (!is_string($this->template)) {
            throw new \InvalidArgumentException('Can not render template of type ' . gettype($this->template));
        }

        return str_replace(['{type}', '{flash}', '{value}'], [$type, $flash, $flash], $this->template);
    }
}
