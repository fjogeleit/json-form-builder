<?php

declare(strict_types=1);

namespace JsonFormBuilder\Service\FormFieldValueFactory;

use JsonFormBuilder\JsonForm\FormField\MultiOptionFormFieldInterface;
use JsonFormBuilder\JsonForm\FormFieldInterface;
use JsonFormBuilder\JsonResult\FormFieldValue\ArrayValue;
use JsonFormBuilder\JsonResult\FormFieldValueInterface;
use JsonFormBuilder\Service\FormFieldValueFactoryInterface;

class ArrayValueFactory implements FormFieldValueFactoryInterface
{
    public function createFromFormField(FormFieldInterface $formField): FormFieldValueInterface
    {
        return new ArrayValue($formField->formFieldId(), $formField->defaultValue());
    }

    public function supports(FormFieldInterface $formField): bool
    {
        return $formField instanceof MultiOptionFormFieldInterface;
    }
}
