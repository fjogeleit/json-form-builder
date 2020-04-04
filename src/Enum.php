<?php

declare(strict_types=1);

namespace JsonFormBuilder;

use MabeEnum\Enum as BaseEnum;

class Enum extends BaseEnum
{
    public function __toString(): string
    {
        return $this->toString();
    }
    public function toString(): string
    {
        return (string)$this->getValue();
    }
}
