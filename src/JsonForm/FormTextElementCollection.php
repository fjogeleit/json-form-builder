<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm;

use JsonFormBuilder\JsonForm\Exception\ItemAlreadyAdded;
use JsonFormBuilder\JsonForm\Service\FormTextElementFactory;
use JsonSerializable;

class FormTextElementCollection extends \ArrayIterator implements JsonSerializable
{
    /**
     * @var FormTextElement[]
     */
    private $elements = [];

    public function __construct(FormTextElement ...$elements)
    {
        parent::__construct($elements);
        $this->elements = $elements;
        $this->sort();
    }

    public static function emptyList(): self
    {
        return new self();
    }

    public function add(FormTextElement $element): self
    {
        if (true === $this->hasField($element->formTextElementId())) {
            throw ItemAlreadyAdded::with($element->formTextElementId());
        }

        $elements = $this->elements;
        $elements[] = $element;

        return new self(...$elements);
    }

    public function replace(FormTextElement $element): self
    {
        return $this->remove($element->formTextElementId())->add($element);
    }

    public function remove(string $formTextElementId): self
    {
        return $this->filter(function (FormTextElement $element) use ($formTextElementId) {
            return $element->formTextElementId() !== $formTextElementId;
        });
    }

    public function filter(callable $callback): self
    {
        return new self(...array_filter($this->elements, $callback));
    }

    public function get(string $formTextElementId): ?FormTextElement
    {
        foreach ($this->elements as $element) {
            if ($element->formTextElementId() === $formTextElementId) {
                return $element;
            }
        }

        return null;
    }

    public function hasField(string $formTextElementId): bool
    {
        return null !== $this->get($formTextElementId);
    }

    public function toArray(): array
    {
        return array_values(
            array_map(function (FormTextElement $element) {
                return $element->toArray();
            }, $this->elements)
        );
    }

    public static function fromArray(array $data): self
    {
        $self = self::emptyList();

        foreach ($data as $element) {
            $self = $self->add(FormTextElementFactory::fromArray($element));
        }

        return $self;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    private function sort(): void
    {
        usort($this->elements, function (FormTextElement $first, FormTextElement $second) {
            return $first->position() <=> $second->position();
        });
    }
}
