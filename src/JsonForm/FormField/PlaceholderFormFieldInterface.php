<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\FormField;

use JsonFormBuilder\JsonForm\FormFieldInterface;

interface PlaceholderFormFieldInterface extends FormFieldInterface
{
    public function placeholder(): ?string;
}
