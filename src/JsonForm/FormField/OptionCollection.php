<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\FormField;

use JsonFormBuilder\JsonForm\Exception\ValueNotExistsInOptions;
use JsonSerializable;

class OptionCollection implements JsonSerializable
{
    /**
     * @var Option[]
     */
    private $options;

    public function __construct(Option ...$options)
    {
        $this->options = $options;
    }

    public static function emptyList(): self
    {
        return new self();
    }

    public function add(Option $option): self
    {
        return new self($option, ...$this->options);
    }

    public function remove(string $value): self
    {
        return $this->filter(function (Option $option) use ($value) {
            return $option->value() !== $value;
        });
    }

    public function filter(callable $callback): self
    {
        return new self(...array_filter($this->options, $callback));
    }

    public function map(callable $callback): array
    {
        return array_map($callback, $this->options);
    }

    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->options, $callback, $initial);
    }

    public function hasValue(string $value): bool
    {
        foreach ($this->options as $option) {
            if ($option->value() === $value) {
                return true;
            }
        }

        return false;
    }

    public function validate(string $value): void
    {
        if (true === $this->hasValue($value)) {
            return;
        }

        throw ValueNotExistsInOptions::with($value);
    }

    public function toArray(): array
    {
        return array_values(
            array_map(function (Option $option) {
                return $option->toArray();
            }, $this->options)
        );
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public static function fromArray(array $data): self
    {
        $self = self::emptyList();

        foreach ($data as $option) {
            $self = $self->add(Option::fromArray($option));
        }

        return $self;
    }
}
