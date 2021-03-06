<?php

declare(strict_types=1);

namespace JsonFormBuilder\Service;

use JsonFormBuilder\JsonForm\Exception\NoClassForFieldTextElementType;
use JsonFormBuilder\JsonForm\FormTextElement\Container;
use JsonFormBuilder\JsonForm\FormTextElement\Headline1;
use JsonFormBuilder\JsonForm\FormTextElement\Headline2;
use JsonFormBuilder\JsonForm\FormTextElement\Headline3;
use JsonFormBuilder\JsonForm\FormTextElement\Headline4;
use JsonFormBuilder\JsonForm\FormTextElement\Headline5;
use JsonFormBuilder\JsonForm\FormTextElement\Headline6;
use JsonFormBuilder\JsonForm\FormTextElement\Paragraph;
use JsonFormBuilder\JsonForm\FormTextElement\Quote;
use JsonFormBuilder\JsonForm\FormTextElementType;

class FormTextElementTypeMapper
{
    protected const MAP = [
        FormTextElementType::HEADLINE_1 => Headline1::class,
        FormTextElementType::HEADLINE_2 => Headline2::class,
        FormTextElementType::HEADLINE_3 => Headline3::class,
        FormTextElementType::HEADLINE_4 => Headline4::class,
        FormTextElementType::HEADLINE_5 => Headline5::class,
        FormTextElementType::HEADLINE_6 => Headline6::class,
        FormTextElementType::PARAGRAPH => Paragraph::class,
        FormTextElementType::QUOTE => Quote::class,
        FormTextElementType::CONTAINER => Container::class,
    ];

    public static function map(FormTextElementType $type): string
    {
        if (false === array_key_exists($type->toString(), self::MAP)) {
            throw NoClassForFieldTextElementType::with($type);
        }

        return self::MAP[$type->toString()];
    }
}
