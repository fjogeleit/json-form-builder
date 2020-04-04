<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\Exception;

use JsonFormBuilder\JsonForm\FormFieldType;

class NoClassForFieldType extends \InvalidArgumentException
{
    public static function with(FormFieldType $formFieldType): self
    {
        return new self(sprintf('A Class for the given FormFieldType "%s" was not found', $formFieldType));
    }
}
