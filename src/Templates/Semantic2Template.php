<?php

namespace Felix\Flash\Templates;

class Semantic2Template implements TemplateInterface
{
    /**
     * {@inheritDoc}
     */
    public function toHtml(string $type, string $message)
    {
        return sprintf('<div class="ui message %s" role="alert">%s</div>', $type, $message);
    }
}
