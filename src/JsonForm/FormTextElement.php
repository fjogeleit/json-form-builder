<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm;

use JsonSerializable;

abstract class FormTextElement implements PositionedElementInterface, JsonSerializable
{
    /**
     * @var string
     */
    protected $formTextElementId;

    /**
     * @var FormTextElementType
     */
    protected $formTextElementType;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var int
     */
    protected $position;

    public function __construct(
        string $formTextElementId,
        FormTextElementType $elementType,
        string $text,
        int $position
    ) {
        $this->formTextElementId = $formTextElementId;
        $this->formTextElementType = $elementType;
        $this->text = $text;
        $this->position = $position;
    }

    public function formTextElementId(): string
    {
        return $this->formTextElementId;
    }

    public function formTextElementType(): FormTextElementType
    {
        return $this->formTextElementType;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function position(): int
    {
        return $this->position;
    }

    public function toArray(): array
    {
        return [
            'formTextElementId' => $this->formTextElementId,
            'formTextElementType' => $this->formTextElementType->toString(),
            'text' => $this->text,
            'position' => $this->position,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

   abstract public static function fromArray(array $data): FormTextElement;

   abstract public static function validate(array $data): void;
}
