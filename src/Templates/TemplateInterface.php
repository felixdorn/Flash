<?php

namespace Felix\Flash\Templates;

interface TemplateInterface
{
    /**
     * @return mixed
     */
    public function toHtml(string $type, string $message);
}
