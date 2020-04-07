<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\FormField;

use Assert\Assertion;
use JsonFormBuilder\JsonForm\Exception\InvalidValueType;
use JsonFormBuilder\JsonForm\FormField;
use JsonFormBuilder\JsonForm\FormFieldInterface;
use JsonFormBuilder\JsonForm\FormFieldType;
use JsonFormBuilder\JsonForm\PositionedElementInterface;
use JsonFormBuilder\JsonResult\FormFieldValue;
use JsonFormBuilder\JsonResult\FormFieldValue\BooleanValue;

class Checkbox extends FormField implements BooleanFormFieldInterface
{
    /**
     * @var boolean
     */
    protected $defaultValue;

    public function __construct(
        string $formFieldId,
        string $label,
        int $position,
        bool $required = false,
        bool $visible = true,
        bool $defaultValue = false
    ) {
        parent::__construct(
            $formFieldId,
            $label,
            FormFieldType::CHECKBOX(),
            $position,
            $required,
            $visible
        );

        $this->defaultValue = $defaultValue;
    }

    public function defaultValue(): bool
    {
        return $this->defaultValue;
    }

    public function withPosition(int $position): PositionedElementInterface
    {
        return new self(
            $this->formFieldId,
            $this->label,
            $position,
            $this->required,
            $this->visible,
            $this->defaultValue
        );
    }

    public function validateValue(FormFieldValue $value): void
    {
        if (true === $value instanceof BooleanValue) {
            return;
        }

        throw InvalidValueType::with($this->formFieldId, BooleanValue::class, $value);
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
            $data['defaultValue'] ?? false,
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
