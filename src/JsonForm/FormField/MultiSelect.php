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
use JsonFormBuilder\JsonResult\FormFieldValue\ArrayValue;

class MultiSelect extends FormField implements MultiOptionFormFieldInterface
{
    /**
     * @var array
     */
    protected $defaultValue;

    /**
     * @var OptionCollection
     */
    protected $options;

    public function __construct(
        string $formFieldId,
        string $label,
        int $position,
        OptionCollection $options,
        bool $required = false,
        bool $visible = true,
        array $defaultValue = []
    ) {
        foreach ($defaultValue as $value) {
            $options->validate($value);
        }

        parent::__construct($formFieldId, $label, FormFieldType::MULTI_SELECT(), $position, $required, $visible);
        $this->options = $options;
        $this->defaultValue = $defaultValue;
    }

    public function options(): OptionCollection
    {
        return $this->options;
    }

    public function defaultValue(): array
    {
        return $this->defaultValue;
    }

    public function withPosition(int $position): PositionedElementInterface
    {
        return new self(
            $this->formFieldId,
            $this->label,
            $position,
            $this->options,
            $this->required,
            $this->visible,
            $this->defaultValue
        );
    }

    public function validateValue(FormFieldValue $value): void
    {
        if (false === $value instanceof ArrayValue) {
            throw InvalidValueType::with($this->formFieldId, ArrayValue::class, $value);
        }

        foreach ($value->value() as $option) {
            $this->options->validate($option);
        }
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), ['options' => $this->options->toArray()]);
    }

    public static function fromArray(array $data): FormFieldInterface
    {
        self::validate($data);

        return new self(
            $data['formFieldId'],
            $data['label'],
            $data['position'],
            OptionCollection::fromArray($data['options']),
            $data['required'],
            $data['visible'],
            $data['defaultValue'] ?? [],
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

        Assertion::keyExists($data, 'options');
        Assertion::isArray($data['options']);
    }
}
