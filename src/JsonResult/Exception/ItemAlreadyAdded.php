<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult\Exception;

use InvalidArgumentException;

class ItemAlreadyAdded extends InvalidArgumentException
{
    public static function with(string $id): self
    {
        return new self('An Item with the ID "%s" already added');
    }
}
