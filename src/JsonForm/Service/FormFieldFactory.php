<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\Service;

use JsonFormBuilder\JsonForm\Exception\InvalidClass;
use JsonFormBuilder\JsonForm\FormFieldInterface;

class FormFieldFactory
{
    public static function fromArray(array $data): FormFieldInterface
    {
        $class = $data['class'];

        if (false === array_key_exists(FormFieldInterface::class, class_implements($class))) {
            throw InvalidClass::with($class, FormFieldInterface::class);
        }

        return $class::fromArray($data);
    }
}
