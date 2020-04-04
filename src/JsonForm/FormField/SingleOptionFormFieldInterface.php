<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\FormField;

use JsonFormBuilder\JsonForm\FormFieldInterface;

interface SingleOptionFormFieldInterface extends FormFieldInterface
{
    public function options(): OptionCollection;
}
