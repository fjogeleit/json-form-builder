<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\Service;

use JsonFormBuilder\JsonForm\Exception\NoClassForFieldType;
use JsonFormBuilder\JsonForm\FormField;
use JsonFormBuilder\JsonForm\FormField\Checkbox;
use JsonFormBuilder\JsonForm\FormField\CheckboxGroup;
use JsonFormBuilder\JsonForm\FormField\Input;
use JsonFormBuilder\JsonForm\FormField\MultiSelect;
use JsonFormBuilder\JsonForm\FormField\RadioButton;
use JsonFormBuilder\JsonForm\FormField\RadioButtonGroup;
use JsonFormBuilder\JsonForm\FormField\Select;
use JsonFormBuilder\JsonForm\FormField\TextArea;
use JsonFormBuilder\JsonForm\FormFieldType;

class FormFieldFactory
{
    protected const MAP = [
        FormFieldType::INPUT => Input::class,
        FormFieldType::TEXT_AREA => TextArea::class,
        FormFieldType::SELECT => Select::class,
        FormFieldType::MULTI_SELECT => MultiSelect::class,
        FormFieldType::CHECKBOX => Checkbox::class,
        FormFieldType::CHECKBOX_GROUP => CheckboxGroup::class,
        FormFieldType::RADIO_BUTTON => RadioButton::class,
        FormFieldType::RADIO_BUTTON_GROUP => RadioButtonGroup::class,
    ];

    public static function fromArray(array $data): FormField
    {
        $fieldType = FormFieldType::fromString($data['formFieldType']);

        if (false === array_key_exists($fieldType->toString(), self::MAP)) {
            throw NoClassForFieldType::with($fieldType);
        }

        $class = self::MAP[$fieldType->toString()];

        return $class::fromArray($data);
    }
}
