<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\FormField;

use Assert\Assertion;
use JsonFormBuilder\JsonForm\Exception\InvalidValueType;
use JsonFormBuilder\JsonForm\FormField;
use JsonFormBuilder\JsonForm\FormFieldInterface;
use JsonFormBuilder\JsonForm\FormFieldType;
use JsonFormBuilder\JsonResult\FormFieldValue;
use JsonFormBuilder\JsonResult\FormFieldValue\StringValue;

class TextArea extends FormField
{
    /**
     * @var string|null
     */
    protected $defaultValue;

    /**
     * @var string|null
     */
    protected $placeholder;

    public function __construct(
        string $formFieldId,
        string $label,
        int $position,
        bool $required = false,
        bool $visible = true,
        string $placeholder = null,
        string $defaultValue = null
    ) {
        parent::__construct(
            $formFieldId,
            $label,
            FormFieldType::TEXT_AREA(),
            $position,
            $required,
            $visible
        );

        $this->placeholder = $placeholder;
        $this->defaultValue = $defaultValue;
    }

    public function defaultValue(): ?string
    {
        return $this->defaultValue;
    }

    public function placeholder(): ?string
    {
        if ('' === $this->placeholder) {
            return null;
        }

        return $this->placeholder;
    }

    public function withPosition(int $position): FormFieldInterface
    {
        return new self(
            $this->formFieldId,
            $this->label,
            $position,
            $this->required,
            $this->visible,
            $this->placeholder,
            $this->defaultValue
        );
    }

    public function validateValue(FormFieldValue $value): void
    {
        if (true === $value instanceof StringValue) {
            return;
        }

        throw InvalidValueType::with($this->formFieldId, StringValue::class, $value);
    }

    public function toArray(): array
    {
        $base = [
            'formFieldId' => $this->formFieldId,
            'label' => $this->label,
            'position' => $this->position,
            'defaultValue' => $this->defaultValue,
            'required' => $this->required,
            'visible' => $this->visible,
            'formFieldType' => $this->formFieldType->toString(),
        ];

        if (false === empty($this->placeholder)) {
            $base['placeholder'] = $this->placeholder;
        }

        return $base;
    }

    public static function fromArray(array $data): FormFieldInterface
    {
        self::validate($data);

        return new self(
            $data['formFieldId'],
            $data['label'],
            $data['position'],
            $data['required'],
            $data['visible'],
            $data['placeholder'] ?? null,
            $data['defaultValue'] ?? null,
        );
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
