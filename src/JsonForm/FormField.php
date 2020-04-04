<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm;

use JsonFormBuilder\JsonResult\FormFieldValue;

abstract class FormField implements FormFieldInterface
{
    /**
     * @var string
     */
    protected $formFieldId;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var FormFieldType
     */
    protected $formFieldType;

    /**
     * @var int
     */
    protected $position;

    /**
     * @var boolean
     */
    protected $required;

    /**
     * @var boolean
     */
    protected $visible;

    public function __construct(
        string $formFieldId,
        string $label,
        FormFieldType $type,
        int $position,
        bool $required = false,
        bool $visible = false
    ) {
        $this->formFieldId = $formFieldId;
        $this->label = $label;
        $this->formFieldType = $type;
        $this->position = $position;
        $this->required = $required;
        $this->visible = $visible;
    }

    public function formFieldId(): string
    {
        return $this->formFieldId;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function formFieldType(): FormFieldType
    {
        return $this->formFieldType;
    }

    public function position(): int
    {
        return $this->position;
    }

    public function required(): bool
    {
        return $this->required;
    }

    public function visible(): bool
    {
        return $this->visible;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    abstract public function withPosition(int $position): FormFieldInterface;

    abstract public function defaultValue();

    abstract public function toArray(): array;

    abstract public function validateValue(FormFieldValue $value): void;

    abstract public static function validate(array $data): void;

    abstract public static function fromArray(array $data): FormFieldInterface;
}
