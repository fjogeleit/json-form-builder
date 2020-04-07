<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult\Service;

use JsonFormBuilder\JsonResult\Exception\InvalidClass;
use JsonFormBuilder\JsonResult\FormFieldValue;
use JsonFormBuilder\JsonResult\FormFieldValueInterface;

class FormFieldValueFactory
{
    public static function fromArray(array $data): FormFieldValue
    {
        $class = $data['class'];

        if (false === array_key_exists(FormFieldValueInterface::class, class_implements($class))) {
            throw InvalidClass::with($class, FormFieldValueInterface::class);
        }

        return $class::fromArray($data);
    }
}
