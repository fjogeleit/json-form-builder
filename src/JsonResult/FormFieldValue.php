<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult;

use JsonSerializable;

abstract class FormFieldValue implements JsonSerializable
{
    /**
     * @var string
     */
    protected $formFieldId;

    /**
     * @var FormFieldValueType
     */
    protected $formFieldValueType;

    public function __construct(string $formFieldId, FormFieldValueType $formFieldValueType)
    {
        $this->formFieldId = $formFieldId;
        $this->formFieldValueType = $formFieldValueType;
    }

    public function formFieldId(): string
    {
        return $this->formFieldId;
    }

    public function formFieldValueType(): FormFieldValueType
    {
        return $this->formFieldValueType;
    }

    abstract public function value();

    public function toArray(): array
    {
        return [
            'formFieldId' => $this->formFieldId,
            'formFieldValueType' => $this->formFieldValueType,
            'value' => $this->value(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
