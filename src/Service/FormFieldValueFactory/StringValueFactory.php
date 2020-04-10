<?php

declare(strict_types=1);

namespace JsonFormBuilder\Service\FormFieldValueFactory;

use JsonFormBuilder\JsonForm\FormField\SingleOptionFormFieldInterface;
use JsonFormBuilder\JsonForm\FormField\StringFormFieldInterface;
use JsonFormBuilder\JsonForm\FormFieldInterface;
use JsonFormBuilder\JsonResult\FormFieldValue\StringValue;
use JsonFormBuilder\JsonResult\FormFieldValueInterface;
use JsonFormBuilder\Service\FormFieldValueFactoryInterface;

class StringValueFactory implements FormFieldValueFactoryInterface
{
    public function createFromFormField(FormFieldInterface $formField): FormFieldValueInterface
    {
        return new StringValue($formField->formFieldId(), $formField->defaultValue());
    }

    public function supports(FormFieldInterface $formField): bool
    {
        return $formField instanceof SingleOptionFormFieldInterface or $formField instanceof StringFormFieldInterface;
    }
}
