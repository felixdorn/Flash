<?php


namespace Felix\Flash\Integrations\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FlashExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('flash', [$this, 'flash'])
        ];
    }

    public function flash(string $type = 'error'): string
    {
        return flash()->render();
    }
}
