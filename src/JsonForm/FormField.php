<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm;

use Assert\Assertion;

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

    public function toArray(): array
    {
        return [
            'formFieldId' => $this->formFieldId,
            'label' => $this->label,
            'position' => $this->position,
            'defaultValue' => $this->defaultValue(),
            'required' => $this->required,
            'visible' => $this->visible,
            'formFieldType' => $this->formFieldType->toString(),
            'class' => get_class($this),
        ];
    }

    public static function validate(array $data): void
    {
        Assertion::keyExists($data, 'formFieldId');
        Assertion::uuid($data['formFieldId']);

        Assertion::keyExists($data, 'label');
        Assertion::string($data['label']);

        Assertion::keyExists($data, 'required');
        Assertion::boolean($data['required']);

        Assertion::keyExists($data, 'visible');
        Assertion::boolean($data['visible']);

        Assertion::keyExists($data, 'position');
        Assertion::integer($data['position']);
    }
}
