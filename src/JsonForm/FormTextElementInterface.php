<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm;

use JsonSerializable;

interface FormTextElementInterface extends PositionedElementInterface, JsonSerializable
{
    public function formTextElementId(): string;

    public function formTextElementType(): FormTextElementType;

    public function text(): string;

    public function position(): int;

    public function toArray(): array;

   public static function fromArray(array $data): FormTextElementInterface;

   public static function validate(array $data): void;
}
