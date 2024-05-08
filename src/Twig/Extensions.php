<?php

namespace App\Twig;

use Stringable;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Extensions extends AbstractExtension {

    public function getFunctions(): array {
        return [
            new TwigFunction('attrs', [$this, 'htmlAttributes'], [
                'is_safe' => ['html']
            ]),
            new TwigFunction('class', [$this, 'toHtmlClass'])
        ];
    }
    /**
     * Parse an array objet to html attributes
     *
     * @param array<string, mixed> $attributes
     */
    public function htmlAttributes(array $attributes): string {
        $string_attributes = [];
        foreach ($attributes as $name => $value) {
            if (!($value === null || is_scalar($value) || $value instanceof Stringable)) continue;
            if (empty($value)) continue;
            $string_attributes[] = "$name='$value'";
        }
        return join(' ', $string_attributes);
    }

    public function toHtmlClass(string ...$args): HtmlClass {
        return new HtmlClass(...$args);
    }
}
