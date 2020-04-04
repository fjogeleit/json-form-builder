<?php

declare(strict_types=1);

namespace JsonFormBuilder\Tests\JsonForm;

use JsonFormBuilder\JsonForm;
use JsonFormBuilder\JsonForm\FormField\Checkbox;
use JsonFormBuilder\JsonForm\FormField\CheckboxGroup;
use JsonFormBuilder\JsonForm\FormField\Input;
use JsonFormBuilder\JsonForm\FormField\InputType;
use JsonFormBuilder\JsonForm\FormField\Option;
use JsonFormBuilder\JsonForm\FormField\OptionCollection;
use JsonFormBuilder\JsonForm\FormField\RadioButton;
use JsonFormBuilder\JsonForm\FormField\RadioButtonGroup;
use JsonFormBuilder\JsonForm\FormField\Select;
use JsonFormBuilder\JsonForm\FormField\TextArea;
use JsonFormBuilder\JsonForm\FormFieldCollection;
use JsonFormBuilder\JsonForm\FormFieldType;
use JsonFormBuilder\JsonForm\FormTextElement\Container;
use JsonFormBuilder\JsonForm\FormTextElement\Headline1;
use JsonFormBuilder\JsonForm\FormTextElement\Headline2;
use JsonFormBuilder\JsonForm\FormTextElement\Headline3;
use JsonFormBuilder\JsonForm\FormTextElement\Headline4;
use JsonFormBuilder\JsonForm\FormTextElement\Headline5;
use JsonFormBuilder\JsonForm\FormTextElement\Headline6;
use JsonFormBuilder\JsonForm\FormTextElement\Paragraph;
use JsonFormBuilder\JsonForm\FormTextElement\Quote;
use JsonFormBuilder\JsonForm\FormTextElementCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateJsonFormTest extends TestCase
{
    public function test_create_empty_form(): void
    {
        $jsonFormId = Uuid::uuid4()->toString();

        $form = new JsonForm(
            $jsonFormId,
            FormFieldCollection::emptyList(),
            FormTextElementCollection::emptyList()
        );

        $this->assertEquals(
            ['jsonFormId' => $jsonFormId, 'formFields' => [], 'formTextElements' => []],
            $form->jsonSerialize()
        );
    }

    public function test_create_form_with_fields(): void
    {
        $jsonFormId = Uuid::uuid4()->toString();

        $form = new JsonForm(
            $jsonFormId,
            FormFieldCollection::emptyList(),
            FormTextElementCollection::emptyList()
        );

        $inputId = Uuid::uuid4()->toString();

        $form->addFormField(new Input($inputId, 'Input', 1));

        $checkboxId = Uuid::uuid4()->toString();

        $form->addFormField(new Checkbox($checkboxId, 'Checkbox', 2));

        $checkboxGroupId = Uuid::uuid4()->toString();

        $form->addFormField(
            new CheckboxGroup(
                $checkboxGroupId,
                'Checkbox',
                3,
                new OptionCollection(new Option('A', '1'), new Option('B', '2'))
            )
        );

        $radioButtonId = Uuid::uuid4()->toString();

        $form->addFormField(new RadioButton($radioButtonId, 'RadioButton', 4));

        $radioButtonGroupId = Uuid::uuid4()->toString();

        $form->addFormField(
            new RadioButtonGroup(
                $radioButtonGroupId,
                'RadioButtonGroup',
                5,
                new OptionCollection(new Option('C', '3'), new Option('D', '4'))
            )
        );

        $selectId = Uuid::uuid4()->toString();

        $form->addFormField(
            new Select(
                $selectId,
                'Select',
                6,
                new OptionCollection(new Option('E', '5'), new Option('F', '6'))
            )
        );

        $textAreaId = Uuid::uuid4()->toString();

        $form->addFormField(new TextArea($textAreaId, 'TextArea', 7));

        $formFields = [
            [
                'formFieldId' => $inputId,
                'formFieldType' => FormFieldType::INPUT,
                'label' => 'Input',
                'defaultValue' => null,
                'required' => false,
                'visible' => true,
                'inputType' => InputType::TEXT,
                'position' => 1,
            ],
            [
                'formFieldId' => $checkboxId,
                'formFieldType' => FormFieldType::CHECKBOX,
                'label' => 'Checkbox',
                'defaultValue' => false,
                'required' => false,
                'visible' => true,
                'position' => 2,
            ],
            [
                'formFieldId' => $checkboxGroupId,
                'formFieldType' => FormFieldType::CHECKBOX_GROUP,
                'label' => 'Checkbox',
                'options' => [['label' => 'A', 'value' => '1'], ['label' => 'B', 'value' => '2']],
                'defaultValue' => [],
                'required' => false,
                'visible' => true,
                'position' => 3,
            ],
            [
                'formFieldId' => $radioButtonId,
                'formFieldType' => FormFieldType::RADIO_BUTTON,
                'label' => 'RadioButton',
                'defaultValue' => false,
                'required' => false,
                'visible' => true,
                'position' => 4,
            ],
            [
                'formFieldId' => $radioButtonGroupId,
                'formFieldType' => FormFieldType::RADIO_BUTTON_GROUP,
                'label' => 'RadioButtonGroup',
                'options' => [['label' => 'C', 'value' => '3'], ['label' => 'D', 'value' => '4']],
                'defaultValue' => null,
                'required' => false,
                'visible' => true,
                'position' => 5,
            ],
            [
                'formFieldId' => $selectId,
                'formFieldType' => FormFieldType::SELECT,
                'label' => 'Select',
                'options' => [['label' => 'E', 'value' => '5'], ['label' => 'F', 'value' => '6']],
                'defaultValue' => null,
                'required' => false,
                'visible' => true,
                'position' => 6,
            ],
            [
                'formFieldId' => $textAreaId,
                'formFieldType' => FormFieldType::TEXT_AREA,
                'label' => 'TextArea',
                'defaultValue' => null,
                'required' => false,
                'visible' => true,
                'position' => 7,
            ]
        ];

        $headline1Id = Uuid::uuid4()->toString();

        $form->addFormTextElement(new Headline1($headline1Id, 'Headline 1', 8));

        $headline2Id = Uuid::uuid4()->toString();

        $form->addFormTextElement(new Headline2($headline2Id, 'Headline 2', 9));

        $headline3Id = Uuid::uuid4()->toString();

        $form->addFormTextElement(new Headline3($headline3Id, 'Headline 3', 10));

        $headline4Id = Uuid::uuid4()->toString();

        $form->addFormTextElement(new Headline4($headline4Id, 'Headline 4', 11));

        $headline5Id = Uuid::uuid4()->toString();

        $form->addFormTextElement(new Headline5($headline5Id, 'Headline 5', 12));

        $headline6Id = Uuid::uuid4()->toString();

        $form->addFormTextElement(new Headline6($headline6Id, 'Headline 6', 13));

        $paragraphId = Uuid::uuid4()->toString();

        $form->addFormTextElement(new Paragraph($paragraphId, 'Paragraph', 14));

        $quoteId = Uuid::uuid4()->toString();

        $form->addFormTextElement(new Quote($quoteId, 'Quote', 15));

        $containerId = Uuid::uuid4()->toString();

        $form->addFormTextElement(new Container($containerId, 'Container', 16));

        $formTextElements = [
            [
                'formTextElementId' => $headline1Id,
                'text' => 'Headline 1',
                'position' => 8,
                'formTextElementType' => 'h1',
            ],
            [
                'formTextElementId' => $headline2Id,
                'text' => 'Headline 2',
                'position' => 9,
                'formTextElementType' => 'h2',
            ],
            [
                'formTextElementId' => $headline3Id,
                'text' => 'Headline 3',
                'position' => 10,
                'formTextElementType' => 'h3',
            ],
            [
                'formTextElementId' => $headline4Id,
                'text' => 'Headline 4',
                'position' => 11,
                'formTextElementType' => 'h4',
            ],
            [
                'formTextElementId' => $headline5Id,
                'text' => 'Headline 5',
                'position' => 12,
                'formTextElementType' => 'h5',
            ],
            [
                'formTextElementId' => $headline6Id,
                'text' => 'Headline 6',
                'position' => 13,
                'formTextElementType' => 'h6',
            ],
            [
                'formTextElementId' => $paragraphId,
                'text' => 'Paragraph',
                'position' => 14,
                'formTextElementType' => 'p',
            ],
            [
                'formTextElementId' => $quoteId,
                'text' => 'Quote',
                'position' => 15,
                'formTextElementType' => 'q',
            ],
            [
                'formTextElementId' => $containerId,
                'text' => 'Container',
                'position' => 16,
                'formTextElementType' => 'div',
            ]
        ];

        $this->assertEquals(
            [
                'jsonFormId' => $jsonFormId,
                'formFields' => $formFields,
                'formTextElements' => $formTextElements
            ],
            $form->jsonSerialize()
        );
    }

    public function test_create_form_from_array(): void
    {
        $jsonFormId = Uuid::uuid4()->toString();

        $inputId = Uuid::uuid4()->toString();
        $checkboxId = Uuid::uuid4()->toString();
        $checkboxGroupId = Uuid::uuid4()->toString();
        $radioButtonId = Uuid::uuid4()->toString();
        $radioButtonGroupId = Uuid::uuid4()->toString();
        $selectId = Uuid::uuid4()->toString();
        $textAreaId = Uuid::uuid4()->toString();

        $formFields = [
            [
                'formFieldId' => $inputId,
                'formFieldType' => FormFieldType::INPUT,
                'label' => 'Input',
                'defaultValue' => null,
                'required' => false,
                'visible' => true,
                'inputType' => InputType::TEXT,
                'position' => 1,
            ],
            [
                'formFieldId' => $checkboxId,
                'formFieldType' => FormFieldType::CHECKBOX,
                'label' => 'Checkbox',
                'defaultValue' => false,
                'required' => false,
                'visible' => true,
                'position' => 2,
            ],
            [
                'formFieldId' => $checkboxGroupId,
                'formFieldType' => FormFieldType::CHECKBOX_GROUP,
                'label' => 'Checkbox',
                'options' => [['label' => 'A', 'value' => '1'], ['label' => 'B', 'value' => '2']],
                'defaultValue' => [],
                'required' => false,
                'visible' => true,
                'position' => 3,
            ],
            [
                'formFieldId' => $radioButtonId,
                'formFieldType' => FormFieldType::RADIO_BUTTON,
                'label' => 'RadioButton',
                'defaultValue' => false,
                'required' => false,
                'visible' => true,
                'position' => 4,
            ],
            [
                'formFieldId' => $radioButtonGroupId,
                'formFieldType' => FormFieldType::RADIO_BUTTON_GROUP,
                'label' => 'RadioButtonGroup',
                'options' => [['label' => 'C', 'value' => '3'], ['label' => 'D', 'value' => '4']],
                'defaultValue' => null,
                'required' => false,
                'visible' => true,
                'position' => 5,
            ],
            [
                'formFieldId' => $selectId,
                'formFieldType' => FormFieldType::SELECT,
                'label' => 'Select',
                'options' => [['label' => 'E', 'value' => '5'], ['label' => 'F', 'value' => '6']],
                'defaultValue' => null,
                'required' => false,
                'visible' => true,
                'position' => 6,
            ],
            [
                'formFieldId' => $textAreaId,
                'formFieldType' => FormFieldType::TEXT_AREA,
                'label' => 'TextArea',
                'defaultValue' => null,
                'required' => false,
                'visible' => true,
                'position' => 7,
            ]
        ];

        $headline1Id = Uuid::uuid4()->toString();
        $headline2Id = Uuid::uuid4()->toString();
        $headline3Id = Uuid::uuid4()->toString();
        $headline4Id = Uuid::uuid4()->toString();
        $headline5Id = Uuid::uuid4()->toString();
        $headline6Id = Uuid::uuid4()->toString();
        $paragraphId = Uuid::uuid4()->toString();
        $quoteId = Uuid::uuid4()->toString();
        $containerId = Uuid::uuid4()->toString();

        $formTextElements = [
            [
                'formTextElementId' => $headline1Id,
                'text' => 'Headline 1',
                'position' => 8,
                'formTextElementType' => 'h1',
            ],
            [
                'formTextElementId' => $headline2Id,
                'text' => 'Headline 2',
                'position' => 9,
                'formTextElementType' => 'h2',
            ],
            [
                'formTextElementId' => $headline3Id,
                'text' => 'Headline 3',
                'position' => 10,
                'formTextElementType' => 'h3',
            ],
            [
                'formTextElementId' => $headline4Id,
                'text' => 'Headline 4',
                'position' => 11,
                'formTextElementType' => 'h4',
            ],
            [
                'formTextElementId' => $headline5Id,
                'text' => 'Headline 5',
                'position' => 12,
                'formTextElementType' => 'h5',
            ],
            [
                'formTextElementId' => $headline6Id,
                'text' => 'Headline 6',
                'position' => 13,
                'formTextElementType' => 'h6',
            ],
            [
                'formTextElementId' => $paragraphId,
                'text' => 'Paragraph',
                'position' => 14,
                'formTextElementType' => 'p',
            ],
            [
                'formTextElementId' => $quoteId,
                'text' => 'Quote',
                'position' => 15,
                'formTextElementType' => 'q',
            ],
            [
                'formTextElementId' => $containerId,
                'text' => 'Container',
                'position' => 16,
                'formTextElementType' => 'div',
            ]
        ];

        $form = JsonForm::fromArray([
            'jsonFormId' => $jsonFormId,
            'formFields' => $formFields,
            'formTextElements' => $formTextElements
        ]);

        $this->assertInstanceOf(JsonForm::class, $form);
        $this->assertInstanceOf(Input::class, $form->formFields()->get($inputId));
        $this->assertInstanceOf(Checkbox::class, $form->formFields()->get($checkboxId));
        $this->assertInstanceOf(CheckboxGroup::class, $form->formFields()->get($checkboxGroupId));
        $this->assertInstanceOf(RadioButton::class, $form->formFields()->get($radioButtonId));
        $this->assertInstanceOf(RadioButtonGroup::class, $form->formFields()->get($radioButtonGroupId));
        $this->assertInstanceOf(Select::class, $form->formFields()->get($selectId));
        $this->assertInstanceOf(TextArea::class, $form->formFields()->get($textAreaId));

        $this->assertInstanceOf(Headline1::class, $form->formTextElements()->get($headline1Id));
        $this->assertInstanceOf(Headline2::class, $form->formTextElements()->get($headline2Id));
        $this->assertInstanceOf(Headline3::class, $form->formTextElements()->get($headline3Id));
        $this->assertInstanceOf(Headline4::class, $form->formTextElements()->get($headline4Id));
        $this->assertInstanceOf(Headline5::class, $form->formTextElements()->get($headline5Id));
        $this->assertInstanceOf(Headline6::class, $form->formTextElements()->get($headline6Id));
        $this->assertInstanceOf(Paragraph::class, $form->formTextElements()->get($paragraphId));
        $this->assertInstanceOf(Quote::class, $form->formTextElements()->get($quoteId));
        $this->assertInstanceOf(Container::class, $form->formTextElements()->get($containerId));
    }
}
