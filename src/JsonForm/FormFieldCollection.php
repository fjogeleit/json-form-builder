<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm;

use ArrayIterator;
use JsonFormBuilder\JsonForm\Exception\ItemAlreadyAdded;
use JsonFormBuilder\JsonForm\Service\FormFieldFactory;
use JsonSerializable;

class FormFieldCollection extends ArrayIterator implements JsonSerializable
{
    /**
     * @var FormFieldInterface[]
     */
    private $formFields = [];

    public function __construct(FormFieldInterface ...$formFields)
    {
        parent::__construct($formFields);
        $this->formFields = $formFields;
        $this->sort();
    }

    public static function emptyList(): self
    {
        return new self();
    }

    public function add(FormFieldInterface $formField): self
    {
        if (true === $this->hasField($formField->formFieldId())) {
            throw ItemAlreadyAdded::with($formField->formFieldId());
        }

        $formFields = $this->formFields;
        $formFields[] = $formField;

        return new self(...$formFields);
    }

    public function replace(FormFieldInterface $formField): self
    {
        return $this->remove($formField->formFieldId())->add($formField);
    }

    public function remove(string $formFieldId): self
    {
        return $this->filter(function (FormFieldInterface $field) use ($formFieldId) {
            return $field->formFieldId() !== $formFieldId;
        });
    }

    public function filter(callable $callback): self
    {
        return new self(...array_filter($this->formFields, $callback));
    }

    public function map(callable $callback): array
    {
        return array_map($callback, $this->formFields);
    }

    public function get(string $formFieldId): ?FormFieldInterface
    {
        foreach ($this->formFields as $formField) {
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

    public function toArray(): array
    {
        return array_values(
            array_map(function (FormFieldInterface $formField) {
                return $formField->toArray();
            }, $this->formFields)
        );
    }

    public static function fromArray(array $data): self
    {
        $self = self::emptyList();

        foreach ($data as $field) {
            $self = $self->add(FormFieldFactory::fromArray($field));
        }

        return $self;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    private function sort(): void
    {
        usort($this->formFields, function (FormFieldInterface $first, FormFieldInterface $second) {
            return $first->position() <=> $second->position();
        });
    }
}
