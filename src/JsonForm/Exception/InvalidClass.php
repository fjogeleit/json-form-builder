<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\Exception;

use InvalidArgumentException;

class InvalidClass extends InvalidArgumentException
{
    public static function with(string $class, string $expected): self
    {
        return new self(sprintf('The given Class "%s" does not implement the expected Interface %s', $class, $expected));
    }
}
