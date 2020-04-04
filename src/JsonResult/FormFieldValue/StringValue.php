<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult\FormFieldValue;

use Assert\Assertion;
use JsonFormBuilder\JsonResult\FormFieldValue;
use JsonFormBuilder\JsonResult\FormFieldValueType;

class StringValue extends FormFieldValue
{
    /**
     * @var string
     */
    protected $value;

    public function __construct(string $formFieldId, ?string $value)
    {
        parent::__construct($formFieldId, FormFieldValueType::STRING());
        $this->value = $value ?? '';
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->value();
    }

    public function isEmpty(): bool
    {
        return true === empty($this->value);
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
        Assertion::string($data['value']);
    }
}
