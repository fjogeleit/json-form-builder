<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\Exception;

use InvalidArgumentException;
use JsonFormBuilder\JsonForm\FormTextElementType;

class NoClassForFieldTextElementType extends InvalidArgumentException
{
    public static function with(FormTextElementType $formTextElementType): self
    {
        return new self(sprintf('A Class for the given FormTextElementType "%s" was not found', $formTextElementType));
    }
}
