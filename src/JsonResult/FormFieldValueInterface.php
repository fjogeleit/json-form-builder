<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult;

use JsonSerializable;

interface FormFieldValueInterface extends JsonSerializable
{
    public function formFieldId(): string;

    public function formFieldValueType(): FormFieldValueType;

    public function value();

    public function toArray(): array;
}
