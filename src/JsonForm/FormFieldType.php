<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm;

use JsonFormBuilder\Enum;

/**
 * @method static self INPUT()
 * @method static self TEXT_AREA()
 * @method static self RADIO_BUTTON()
 * @method static self RADIO_BUTTON_GROUP()
 * @method static self CHECKBOX()
 * @method static self CHECKBOX_GROUP()
 * @method static self SELECT()
 * @method static self MULTI_SELECT()
 */
class FormFieldType extends Enum
{
    public const INPUT = 'input';
    public const TEXT_AREA = 'textarea';
    public const RADIO_BUTTON = 'radio_button';
    public const RADIO_BUTTON_GROUP = 'radio_button_group';
    public const CHECKBOX = 'checkbox';
    public const CHECKBOX_GROUP = 'checkbox_group';
    public const SELECT = 'select';
    public const MULTI_SELECT = 'multi_select';

    public static function fromString(string $value): self
    {
        return self::byValue($value);
    }
}
