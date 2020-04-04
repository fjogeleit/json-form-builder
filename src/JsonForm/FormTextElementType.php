<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm;

use JsonFormBuilder\Enum;

/**
 * @method static self HEADLINE_1()
 * @method static self HEADLINE_2()
 * @method static self HEADLINE_3()
 * @method static self HEADLINE_4()
 * @method static self HEADLINE_5()
 * @method static self HEADLINE_6()
 *
 * @method static self PARAGRAPH()
 * @method static self QUOTE()
 * @method static self CONTAINER()
 */
class FormTextElementType extends Enum
{
    public const HEADLINE_1 = 'h1';
    public const HEADLINE_2 = 'h2';
    public const HEADLINE_3 = 'h3';
    public const HEADLINE_4 = 'h4';
    public const HEADLINE_5 = 'h5';
    public const HEADLINE_6 = 'h6';

    public const PARAGRAPH = 'p';
    public const QUOTE = 'q';
    public const CONTAINER = 'div';

    public static function fromString(string $value): self
    {
        return self::byValue($value);
    }
}
