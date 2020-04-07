<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm;

abstract class FormTextElement implements FormTextElementInterface
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
            'class' => get_class($this)
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
