<?php
declare(strict_types=1);

namespace PhpStyler;

class Config
{
    /**
     * @param string[] $files
     */
    public function __construct(
        public readonly Styler $styler,
        public readonly iterable $files = [],
    ) {
    }
}
