<?php

declare(strict_types=1);

namespace JsonFormBuilder\Service;

use JsonFormBuilder\JsonForm\FormFieldInterface;
use JsonFormBuilder\JsonResult\FormFieldValueInterface;

interface FormFieldValueFactoryInterface
{
    public function createFromFormField(FormFieldInterface $formField): FormFieldValueInterface;

    public function supports(FormFieldInterface $formField): bool;
}
