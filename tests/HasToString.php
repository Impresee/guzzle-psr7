<?php

declare(strict_types=1);

namespace ImpreseeGuzzleHttp\Tests\Psr7;

class HasToString
{
    public function __toString(): string
    {
        return 'foo';
    }
}
