<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\Exception;

class ValueNotExistsInOptions extends \InvalidArgumentException
{
    public static function with(string $value): self
    {
        return new self(sprintf('A value "%s" not exists in the given options', $value));
    }
}
