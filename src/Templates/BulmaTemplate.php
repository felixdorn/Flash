<?php


namespace Felix\Flash\Templates;

class BulmaTemplate implements TemplateInterface
{
    /**
     * @inheritDoc
     */
    public function toHtml(string $type, string $message)
    {
        return sprintf('<div class="notification is-%s mt-4" role="alert">%s</div>', $type, $message);
    }
}
