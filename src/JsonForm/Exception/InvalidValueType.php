<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\Exception;

use JsonFormBuilder\JsonResult\FormFieldValue;

class InvalidValueType extends \InvalidArgumentException
{
    public static function with(string $formFieldId, string $expected, FormFieldValue $actual): self
    {
        return new self(sprintf('FormField "%s" required a "%s" - "%s" given', $formFieldId, $expected, \get_class($actual)));
    }
}
