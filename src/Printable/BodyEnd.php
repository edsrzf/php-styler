<?php
declare(strict_types=1);

namespace PhpStyler\Printable;

class BodyEnd extends Printable
{
    public function __construct(
        public readonly string $type
    ) {
    }
}
