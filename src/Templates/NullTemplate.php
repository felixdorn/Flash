<?php


namespace Felix\Flash\Templates;


class NullTemplate implements TemplateInterface
{

    /**
     * @inheritDoc
     */
    public function toHtml(string $type, string $message)
    {
        return '';
    }
}
