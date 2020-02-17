<?php


namespace Felix\Flash\Templates;

interface TemplateInterface
{
    /**
     * @param string $type
     * @param string $message
     * @return mixed
     */
    public function toHtml(string $type, string $message);
}
