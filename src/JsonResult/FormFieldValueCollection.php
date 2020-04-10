<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult;

use JsonFormBuilder\JsonResult\Exception\ItemAlreadyAdded;
use JsonFormBuilder\JsonResult\Service\FormFieldValueFactory;
use JsonSerializable;

class FormFieldValueCollection implements JsonSerializable
{
    /**
     * @var FormFieldValueInterface[]
     */
    private $formFieldValues = [];

    public function __construct(FormFieldValueInterface ...$formFieldValues)
    {
        $this->formFieldValues = $formFieldValues;
    }

    public static function emptyList(): self
    {
        return new self();
    }

    public function add(FormFieldValueInterface $formFieldValue): self
    {
        if (true === $this->hasField($formFieldValue->formFieldId())) {
            throw ItemAlreadyAdded::with($formFieldValue->formFieldId());
        }

        $formFieldValues = $this->formFieldValues;
        $formFieldValues[] = $formFieldValue;

        return new self(...$formFieldValues);
    }

    public function remove(string $formFieldValueId): self
    {
        return $this->filter(function (FormFieldValueInterface $element) use ($formFieldValueId) {
            return $element->formFieldId() !== $formFieldValueId;
        });
    }

    public function filter(callable $callback): self
    {
        return new self(...array_filter($this->formFieldValues, $callback));
    }

    public function replace(FormFieldValueInterface $formField): self
    {
        return $this->remove($formField->formFieldId())->add($formField);
    }

    public function map(callable $callable): array
    {
        return array_map($callable, $this->formFieldValues);
    }

    public function get(string $formFieldId): ?FormFieldValueInterface
    {
        foreach ($this->formFieldValues as $formField) {
            if ($formField->formFieldId() === $formFieldId) {
                return $formField;
            }
        }

        return null;
    }

    public function hasField(string $formFieldId): bool
    {
        return null !== $this->get($formFieldId);
    }

    public function forEach(callable $callback): void
    {
        foreach ($this->formFieldValues as $fieldValue) {
            $callback($fieldValue);
        }
    }

    public function toArray(): array
    {
        return array_values(
            array_map(function (FormFieldValueInterface $formFieldValue) {
                return $formFieldValue->jsonSerialize();
            }, $this->formFieldValues)
        );
    }

    public static function fromArray(array $data): self
    {
        $self = self::emptyList();

        foreach ($data as $field) {
            $self = $self->add(FormFieldValueFactory::fromArray($field));
        }

        return $self;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
