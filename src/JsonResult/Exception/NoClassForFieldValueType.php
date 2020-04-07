<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult\Exception;

use InvalidArgumentException;
use JsonFormBuilder\JsonResult\FormFieldValueType;

class NoClassForFieldValueType extends InvalidArgumentException
{
    public static function with(FormFieldValueType $formFieldValueType): self
    {
        return new self(sprintf('A Class for the given FormFieldValueType "%s" was not found', $formFieldValueType));
    }
}
