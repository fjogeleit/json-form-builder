<?php

declare(strict_types=1);

namespace JsonFormBuilder\Tests\Service;

use JsonFormBuilder\JsonForm\FormField\CheckboxGroup;
use JsonFormBuilder\JsonForm\FormField\Input;
use JsonFormBuilder\JsonForm\FormField\Option;
use JsonFormBuilder\JsonForm\FormField\OptionCollection;
use JsonFormBuilder\JsonForm\FormField\RadioButton;
use JsonFormBuilder\JsonForm\FormFieldCollection;
use JsonFormBuilder\JsonResult\FormFieldValue\ArrayValue;
use JsonFormBuilder\JsonResult\FormFieldValue\BooleanValue;
use JsonFormBuilder\JsonResult\FormFieldValue\StringValue;
use JsonFormBuilder\JsonResult\FormFieldValueCollection;
use JsonFormBuilder\Service\FormFieldValueCollectionFactory;
use JsonFormBuilder\Service\FormFieldValueFactory\ArrayValueFactory;
use JsonFormBuilder\Service\FormFieldValueFactory\BooleanValueFactory;
use JsonFormBuilder\Service\FormFieldValueFactory\StringValueFactory;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class FormFieldValueCollectionFactoryTest extends TestCase
{
    /**
     * @var FormFieldValueCollectionFactory
     */
    private $valueFactory;

    protected function setUp(): void
    {
        $this->valueFactory = new FormFieldValueCollectionFactory(
            [],
            [
                new ArrayValueFactory(),
                new BooleanValueFactory(),
                new StringValueFactory()
            ]
        );
    }

    public function test_create_a_blueprint_valueCollection_for_a_given_formFieldCollection()
    {
        $inputId = Uuid::uuid4()->toString();
        $checkboxGroupId = Uuid::uuid4()->toString();
        $radioButtonId = Uuid::uuid4()->toString();

        $formFieldCollection = FormFieldCollection::emptyList()
            ->add(new Input($inputId, 'Input', 1))
            ->add(new RadioButton($radioButtonId, 'RadioButton', 2))
            ->add(
                new CheckboxGroup(
                    $checkboxGroupId,
                    'Checkbox',
                    3,
                    new OptionCollection(new Option('A', '1'), new Option('B', '2'))
                )
            );

        $valueCollection = $this->valueFactory->createFromCollection($formFieldCollection);

        $this->assertInstanceOf(FormFieldValueCollection::class, $valueCollection);
        $this->assertInstanceOf(StringValue::class, $valueCollection->get($inputId));
        $this->assertInstanceOf(ArrayValue::class, $valueCollection->get($checkboxGroupId));
        $this->assertInstanceOf(BooleanValue::class, $valueCollection->get($radioButtonId));
    }
}
