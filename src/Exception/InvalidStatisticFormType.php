<?php

declare(strict_types=1);

namespace JsonFormBuilder\Exception;

use InvalidArgumentException;
use JsonFormBuilder\JsonForm\FormFieldType;

class InvalidStatisticFormType extends InvalidArgumentException
{
    public static function forType(FormFieldType $formFieldType): self
    {
        return new self(sprintf('Could not process FormType %s', $formFieldType->toString()));
    }
}
