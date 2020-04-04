<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult;

use JsonFormBuilder\Enum;

/**
 * @method static self STRING()
 * @method static self ARRAY()
 * @method static self BOOLEAN()
 */
class FormFieldValueType extends Enum
{
    public const STRING = 'string';
    public const ARRAY = 'array';
    public const BOOLEAN = 'boolean';

    public static function fromString(string $value): self
    {
        return self::byValue($value);
    }
}
