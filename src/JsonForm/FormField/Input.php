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
use JsonFormBuilder\JsonResult\FormFieldValue\StringValue;

class Input extends FormField implements StringFormFieldInterface, PlaceholderFormFieldInterface
{
    /**
     * @var string|null
     */
    protected $defaultValue;

    /**
     * @var InputType
     */
    protected $inputType;

    /**
     * @var string|null
     */
    protected $placeholder;

    /**
     * @var string|int|null
     */
    protected $min;

    /**
     * @var string|int|null
     */
    protected $max;

    public function __construct(
        string $formFieldId,
        string $label,
        int $position,
        InputType $inputType = null,
        bool $required = false,
        bool $visible = true,
        string $placeholder = null,
        string $min = null,
        string $max = null,
        string $defaultValue = null
    ) {
        parent::__construct(
            $formFieldId,
            $label,
            FormFieldType::INPUT(),
            $position,
            $required,
            $visible
        );

        $this->inputType = $inputType ?? InputType::TEXT();
        $this->placeholder = $placeholder;
        $this->min = $min;
        $this->max = $max;
        $this->defaultValue = $defaultValue;
    }

    public function defaultValue(): ?string
    {
        return $this->defaultValue;
    }

    public function inputType(): InputType
    {
        return $this->inputType;
    }

    public function placeholder(): ?string
    {
        if ('' === $this->placeholder) {
            return null;
        }

        return $this->placeholder;
    }

    public function min()
    {
        if ('' === $this->min) {
            return null;
        }

        return $this->min;
    }

    public function max()
    {
        if ('' === $this->max) {
            return null;
        }

        return $this->max;
    }

    public function withPosition(int $position): PositionedElementInterface
    {
        return new self(
            $this->formFieldId,
            $this->label,
            $position,
            $this->inputType,
            $this->required,
            $this->visible,
            $this->placeholder,
            $this->min,
            $this->max,
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
        $base = array_merge(parent::toArray(), ['inputType' => $this->inputType->toString()]);

        if (false === empty($this->placeholder)) {
            $base['placeholder'] = $this->placeholder;
        }

        if (false === empty($this->min)) {
            $base['min'] = $this->min;
        }

        if (false === empty($this->max)) {
            $base['min'] = $this->max;
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
            InputType::fromString($data['inputType']),
            $data['required'],
            $data['visible'],
            $data['placeholder'] ?? null,
            $data['min'] ?? null,
            $data['max'] ?? null,
            $data['defaultValue'] ?? null,
        );
    }

    public static function validate(array $data): void
    {
        parent::validate($data);

        Assertion::keyExists($data, 'inputType');
        Assertion::string($data['inputType']);
    }
}
