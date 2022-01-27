<?php

namespace Felix\Flash\Templates;

class BootstrapTemplate implements TemplateInterface
{
    /**
     * {@inheritDoc}
     */
    public function toHtml(string $type, string $message)
    {
        return sprintf('<div class="alert alert-%s mt-4" role="alert">%s</div>', $type, $message);
    }
}
