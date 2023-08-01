<?php
declare(strict_types=1);

namespace PhpStyler\Printable;

class Array_ extends Printable
{
    public function __construct(
        public readonly int $count
    ) {
    }
}
