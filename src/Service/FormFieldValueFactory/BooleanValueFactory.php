<?php

declare(strict_types=1);

namespace JsonFormBuilder\Service\FormFieldValueFactory;

use JsonFormBuilder\JsonForm\FormField\BooleanFormFieldInterface;
use JsonFormBuilder\JsonForm\FormFieldInterface;
use JsonFormBuilder\JsonResult\FormFieldValue\BooleanValue;
use JsonFormBuilder\JsonResult\FormFieldValueInterface;
use JsonFormBuilder\Service\FormFieldValueFactoryInterface;

class BooleanValueFactory implements FormFieldValueFactoryInterface
{
    public function createFromFormField(FormFieldInterface $formField): FormFieldValueInterface
    {
        return new BooleanValue($formField->formFieldId(), $formField->defaultValue());
    }

    public function supports(FormFieldInterface $formField): bool
    {
        return $formField instanceof BooleanFormFieldInterface;
    }
}
