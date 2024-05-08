<?php

namespace App\Twig;

class HtmlClass {
    private $classes = [];

    public function __construct(string ...$classNames) {
        foreach($classNames as $class) {
            $this->add($class);
        }
    }

    public function add(string $class): self {
        if (empty($class))
            return $this;
        array_push($this->classes, ...explode(' ', $class));
        return $this;
    }

    public function __toString(): string {
        return implode(' ', $this->classes);
    }
}
