<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\FormField;

use Assert\Assertion;
use JsonSerializable;

class Option implements JsonSerializable
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $value;

    public function __construct(string $label, string $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public static function fromArray(array $data): self
    {
        self::validate($data);

        return new self(
            $data['label'],
            $data['value']
        );
    }

    public static function validate(array $data): void
    {
        Assertion::keyExists($data, 'label');
        Assertion::string($data['label']);

        Assertion::keyExists($data, 'value');
        Assertion::string($data['value']);
    }
}
