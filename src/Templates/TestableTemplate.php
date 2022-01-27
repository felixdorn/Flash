<?php

namespace Felix\Flash\Templates;

class TestableTemplate implements TemplateInterface
{
    /**
     * {@inheritDoc}
     */
    public function toHtml(string $type, string $message)
    {
        return sprintf('%s %s', $type, $message);
    }
}
