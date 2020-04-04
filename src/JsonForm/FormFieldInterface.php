<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm;

use JsonFormBuilder\JsonResult\FormFieldValue;
use JsonSerializable;

interface FormFieldInterface extends JsonSerializable, PositionedElementInterface
{
    public function formFieldId(): string;

    public function label(): string;

    public function formFieldType(): FormFieldType;

    public function required(): bool;

    public function visible(): bool;

    public function withPosition(int $position): self;

    public function jsonSerialize(): array;

    public function defaultValue();

    public function toArray(): array;

    public function validateValue(FormFieldValue $value): void;

    public static function validate(array $data): void;

    public static function fromArray(array $data): self;
}
