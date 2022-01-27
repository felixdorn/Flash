<?php

namespace Felix\Flash\Templates;

class SpectreTemplate implements TemplateInterface
{
    /**
     * {@inheritDoc}
     */
    public function toHtml(string $type, string $message)
    {
        $type = ($type === 'info') ? 'primary' : $type;

        return sprintf('<div class="toast toast-%s" role="alert">%s</div>', $type, $message);
    }
}
