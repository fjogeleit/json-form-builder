<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult\Service;

use JsonFormBuilder\JsonResult\Exception\NoClassForFieldValueType;
use JsonFormBuilder\JsonResult\FormFieldValue;
use JsonFormBuilder\JsonResult\FormFieldValue\ArrayValue;
use JsonFormBuilder\JsonResult\FormFieldValue\BooleanValue;
use JsonFormBuilder\JsonResult\FormFieldValue\StringValue;
use JsonFormBuilder\JsonResult\FormFieldValueType;

class FormFieldValueFactory
{
    private const MAP = [
        FormFieldValueType::STRING => StringValue::class,
        FormFieldValueType::ARRAY => ArrayValue::class,
        FormFieldValueType::BOOLEAN => BooleanValue::class,
    ];

    public static function fromArray(array $data): FormFieldValue
    {
        $type = FormFieldValueType::fromString($data['formFieldValueType']);

        if (false === array_key_exists($type->toString(), self::MAP)) {
            throw NoClassForFieldValueType::with($type);
        }

        $class = self::MAP[$type->toString()];

        return $class::fromArray($data);
    }
}
