<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult\FormFieldValue;

use Assert\Assertion;
use JsonFormBuilder\JsonResult\FormFieldValue;
use JsonFormBuilder\JsonResult\FormFieldValueInterface;
use JsonFormBuilder\JsonResult\FormFieldValueType;

class ArrayValue extends FormFieldValue
{
    /**
     * @var array
     */
    protected $value;

    public function __construct(string $formFieldId, ?array $value = [])
    {
        Assertion::allString($value, 'A ArrayValue should only contain strings');

        parent::__construct($formFieldId, FormFieldValueType::ARRAY());
        $this->value = $value;
    }

    public function value(): array
    {
        return $this->value;
    }

    public function withValue($value): FormFieldValueInterface
    {
        Assertion::isArray($value);

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
        Assertion::isArray($data['value']);
        Assertion::allString($data['value']);
    }
}
