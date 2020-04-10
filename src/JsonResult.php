<?php

declare(strict_types=1);

namespace JsonFormBuilder;

use Assert\Assertion;
use JsonFormBuilder\JsonResult\FormFieldValueCollection;
use JsonFormBuilder\JsonResult\FormFieldValueInterface;
use JsonSerializable;

class JsonResult implements JsonSerializable
{
    /**
     * @var string
     */
    protected $jsonResultId;

    /**
     * @var string
     */
    protected $jsonFormId;

    /**
     * @var FormFieldValueCollection
     */
    protected $formFieldValues;

    public function __construct(string $jsonResultId, string $jsonFormId, FormFieldValueCollection $formFieldValues)
    {
        $this->jsonResultId = $jsonResultId;
        $this->formFieldValues = $formFieldValues;
        $this->jsonFormId = $jsonFormId;
    }

    public function jsonResultId(): string
    {
        return $this->jsonResultId;
    }

    public function jsonFormId(): string
    {
        return $this->jsonFormId;
    }

    public function formFieldValues(): FormFieldValueCollection
    {
        return $this->formFieldValues;
    }

    public function getValue(string $fieldValueId): ?FormFieldValueInterface
    {
        return $this->formFieldValues()->get($fieldValueId);
    }

    public function addValue(FormFieldValueInterface $fieldValue): void
    {
        $this->formFieldValues = $this->formFieldValues()->add($fieldValue);
    }

    public function replaceValue(FormFieldValueInterface $fieldValue): void
    {
        $this->formFieldValues = $this->formFieldValues()->replace($fieldValue);
    }

    public function removeValue(string $fieldValueId): void
    {
        $this->formFieldValues = $this->formFieldValues()->remove($fieldValueId);
    }

    public function replaceValues(FormFieldValueCollection $fieldValues): void
    {
        $this->formFieldValues = $fieldValues;
    }

    public function toArray()
    {
        return [
            'jsonResultId' => $this->jsonResultId,
            'jsonFormId' => $this->jsonFormId,
            'fieldValues' => $this->formFieldValues->toArray()
        ];
    }

    public static function fromArray(array $data): self
    {
        self::validate($data);

        return new self(
            $data['jsonResultId'],
            $data['jsonFormId'],
            FormFieldValueCollection::fromArray($data['fieldValues'])
        );
    }

    public static function validate(array $data): void
    {
        Assertion::keyExists($data, 'jsonResultId');
        Assertion::uuid($data['jsonResultId']);

        Assertion::keyExists($data, 'jsonFormId');
        Assertion::uuid($data['jsonResultId']);

        Assertion::keyExists($data, 'fieldValues');
        Assertion::isArray($data['fieldValues']);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
