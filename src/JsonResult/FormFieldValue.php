<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult;

abstract class FormFieldValue implements FormFieldValueInterface
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
            'formFieldValueType' => $this->formFieldValueType->toString(),
            'value' => $this->value(),
            'class' => get_class($this)
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
