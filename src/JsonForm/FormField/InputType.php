<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\FormField;

use JsonFormBuilder\Enum;

/**
 * @method static self TEXT()
 * @method static self NUMBER()
 * @method static self DATE()
 * @method static self DATETIME()
 * @method static self DATETIME_LOCAL()
 * @method static self EMAIL()
 * @method static self RANGE()
 * @method static self PASSWORD()
 * @method static self WEEK()
 * @method static self COLOR()
 * @method static self TEL()
 * @method static self TIME()
 */
class InputType extends Enum
{
    public const TEXT = 'text';
    public const NUMBER = 'number';
    public const DATE = 'date';
    public const DATETIME = 'datetime';
    public const DATETIME_LOCAL = 'datetime-local';
    public const EMAIL = 'email';
    public const RANGE = 'range';
    public const PASSWORD = 'password';
    public const WEEK = 'week';
    public const COLOR = 'color';
    public const TEL = 'tel';
    public const TIME = 'time';
    public const IMAGE = 'image';

    public static function fromString(string $value): self
    {
        return self::byValue($value);
    }
}
