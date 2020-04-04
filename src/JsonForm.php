<?php

declare(strict_types=1);

namespace JsonFormBuilder;

use Assert\Assertion;
use JsonFormBuilder\JsonForm\FormField;
use JsonFormBuilder\JsonForm\FormFieldCollection;
use JsonFormBuilder\JsonForm\FormTextElement;
use JsonFormBuilder\JsonForm\FormTextElementCollection;
use JsonFormBuilder\JsonResult\FormFieldValue;
use JsonSerializable;

class JsonForm implements JsonSerializable
{
    /**
     * @var string
     */
    protected $jsonFormId;

    /**
     * @var FormFieldCollection
     */
    private $formFields;

    /**
     * @var FormTextElementCollection
     */
    private $formTextElements;

    public function __construct(
        string $jsonFormId,
        FormFieldCollection $formFields,
        FormTextElementCollection $formTextElement
    ) {
        $this->jsonFormId = $jsonFormId;
        $this->formFields = $formFields;
        $this->formTextElements = $formTextElement;
    }

    public function jsonFormId(): string
    {
        return $this->jsonFormId;
    }

    public function formFields(): FormFieldCollection
    {
        return $this->formFields;
    }

    public function formTextElements(): FormTextElementCollection
    {
        return $this->formTextElements;
    }

    public function addFormField(FormField $formField): void
    {
        $this->formFields = $this->formFields()->add($formField);
    }

    public function addFormTextElement(FormTextElement $formTextElement): void
    {
        $this->formTextElements = $this->formTextElements()->add($formTextElement);
    }

    public function removeFormField(string $formFieldId): void
    {
        $this->formFields = $this->formFields()->remove($formFieldId);
    }

    public function removeFormTextElement(string $formTextElementId): void
    {
        $this->formTextElements = $this->formTextElements()->remove($formTextElementId);
    }

    public function validateResult(JsonResult $jsonResult): bool
    {
        $jsonResult->formFieldValues()->forEach(function (FormFieldValue $fieldValue) {
            $formField = $this->formFields()->get($fieldValue->formFieldId());

            if (null === $formField) {
                return;
            }

            $formField->validateValue($fieldValue);
        });

        return true;
    }

    public function toArray(): array
    {
        return [
            'jsonFormId' => $this->jsonFormId,
            'formFields' => $this->formFields->toArray(),
            'formTextElements' => $this->formTextElements->toArray(),
        ];
    }

    public static function fromArray(array $data): self
    {
        self::validate($data);

        return new self(
            $data['jsonFormId'],
            FormFieldCollection::fromArray($data['formFields']),
            FormTextElementCollection::fromArray($data['formTextElements'])
        );
    }

    public static function validate(array $data): void
    {
        Assertion::keyExists($data, 'jsonFormId');
        Assertion::uuid($data['jsonFormId']);

        Assertion::keyExists($data, 'formFields');
        Assertion::isArray($data['formFields']);

        Assertion::keyExists($data, 'formTextElements');
        Assertion::isArray($data['formTextElements']);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
