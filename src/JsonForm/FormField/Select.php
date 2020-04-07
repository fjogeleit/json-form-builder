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

class Select extends FormField implements SingleOptionFormFieldInterface
{
    /**
     * @var string
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
        string $defaultValue = null
    ) {
        if (false === empty($defaultValue)) {
            $options->validate((string)$defaultValue);
        }

        parent::__construct($formFieldId, $label, FormFieldType::SELECT(), $position, $required, $visible);
        $this->options = $options;
        $this->defaultValue = $defaultValue;
    }

    public function defaultValue(): ?string
    {
        return $this->defaultValue;
    }

    public function options(): OptionCollection
    {
        return $this->options;
    }

    public function withPosition(int $position): FormFieldInterface
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
        if (false === $value instanceof StringValue) {
            throw InvalidValueType::with($this->formFieldId, StringValue::class, $value);
        }

        if (true === empty($value->value())) {
            return;
        }

        $this->options->validate($value->value());
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

        Assertion::keyExists($data, 'options');
        Assertion::isArray($data['options']);
    }
}
