<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult\FormFieldValue;

use Assert\Assertion;
use JsonFormBuilder\JsonResult\FormFieldValue;
use JsonFormBuilder\JsonResult\FormFieldValueInterface;
use JsonFormBuilder\JsonResult\FormFieldValueType;

class BooleanValue extends FormFieldValue
{
    /**
     * @var bool
     */
    protected $value;

    public function __construct(string $formFieldId, ?bool $value)
    {
        parent::__construct($formFieldId, FormFieldValueType::BOOLEAN());
        $this->value = $value ?? false;
    }

    public function value(): bool
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->value ? 'true' : 'false';
    }

    public function withValue($value): FormFieldValueInterface
    {
        Assertion::boolean($value);

        return new self($this->formFieldId, $value);
    }

    public static function fromArray(array $data): self
    {
        self::validate($data);

        return new self(
            $data['formFieldId'],
            $data['value']
        );
    }

    public static function validate(array $data): void
    {
        Assertion::keyExists($data, 'formFieldId');
        Assertion::uuid($data['formFieldId']);

        Assertion::keyExists($data, 'value');
        Assertion::boolean($data['value']);
    }
}
