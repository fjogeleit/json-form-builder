<?php

declare(strict_types=1);

namespace JsonFormBuilder\Tests\JsonResult;

use JsonFormBuilder\JsonForm;
use JsonFormBuilder\JsonForm\FormField\Checkbox;
use JsonFormBuilder\JsonForm\FormField\CheckboxGroup;
use JsonFormBuilder\JsonForm\FormField\Input;
use JsonFormBuilder\JsonForm\FormField\Option;
use JsonFormBuilder\JsonForm\FormField\OptionCollection;
use JsonFormBuilder\JsonForm\FormFieldCollection;
use JsonFormBuilder\JsonForm\FormTextElement\Headline1;
use JsonFormBuilder\JsonForm\FormTextElement\Paragraph;
use JsonFormBuilder\JsonForm\FormTextElementCollection;
use JsonFormBuilder\JsonResult;
use JsonFormBuilder\JsonResult\FormFieldValue\ArrayValue;
use JsonFormBuilder\JsonResult\FormFieldValue\BooleanValue;
use JsonFormBuilder\JsonResult\FormFieldValue\StringValue;
use JsonFormBuilder\JsonResult\FormFieldValueCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateJsonResultTest extends TestCase
{
    public function test_create_json_result_for_form()
    {
        $formId = Uuid::uuid4()->toString();
        $inputId = Uuid::uuid4()->toString();
        $checkboxId = Uuid::uuid4()->toString();
        $checkboxGroupId = Uuid::uuid4()->toString();

        $formFields = FormFieldCollection::emptyList()
            ->add(new Input($inputId, 'Input', 1))
            ->add(new Checkbox($checkboxId, 'Checkbox', 2))
            ->add(new CheckboxGroup(
                $checkboxGroupId,
                'CheckboxGroup',
                3,
                OptionCollection::emptyList()
                    ->add(new Option('A', 'A'))
                    ->add(new Option('B', 'B'))
            ));

        $form = new JsonForm($formId, $formFields, FormTextElementCollection::emptyList());

        $resultId = Uuid::uuid4()->toString();

        $values = FormFieldValueCollection::emptyList()
            ->add(new StringValue($inputId, 'Text'))
            ->add(new BooleanValue($checkboxId, true))
            ->add(new ArrayValue($checkboxGroupId, ['A', 'B']));

        $result = new JsonResult($resultId, $formId, $values);

        $this->assertTrue($form->validateResult($result));
    }

    public function test_create_valid_json(): void
    {
        $formFields = FormFieldCollection::emptyList()
            ->add(new Input(Uuid::uuid4()->toString(), 'Input', 3))
            ->add(new Checkbox(Uuid::uuid4()->toString(), 'Checkbox', 4))
            ->add(new CheckboxGroup(
                Uuid::uuid4()->toString(),
                'CheckboxGroup',
                5,
                OptionCollection::emptyList()
                    ->add(new Option('A', 'A'))
                    ->add(new Option('B', 'B'))
            ));

        $formElements = FormTextElementCollection::emptyList()
            ->add(new Headline1(Uuid::uuid4()->toString(), 'Your First Dynamic Form', 1))
            ->add(new Paragraph(Uuid::uuid4()->toString(), 'Create your custom Form', 2));

        $form = new JsonForm(Uuid::uuid4()->toString(), $formFields, $formElements);

        $this->assertIsString(json_encode($form));
    }
}
