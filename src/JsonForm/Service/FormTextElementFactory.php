<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\Service;

use JsonFormBuilder\JsonForm\Exception\InvalidClass;
use JsonFormBuilder\JsonForm\FormTextElementInterface;

class FormTextElementFactory
{
    public static function fromArray(array $data): FormTextElementInterface
    {
        $class = $data['class'];

        if (false === array_key_exists(FormTextElementInterface::class, class_implements($class))) {
            throw InvalidClass::with($class, FormTextElementInterface::class);
        }

        return $class::fromArray($data);
    }
}
