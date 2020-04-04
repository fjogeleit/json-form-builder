<?php

declare(strict_types=1);

namespace JsonFormBuilder\Tests\Statistic;

use JsonFormBuilder\JsonForm;
use JsonFormBuilder\JsonForm\FormField\Checkbox;
use JsonFormBuilder\JsonForm\FormField\CheckboxGroup;
use JsonFormBuilder\JsonForm\FormField\Option;
use JsonFormBuilder\JsonForm\FormField\OptionCollection;
use JsonFormBuilder\JsonForm\FormField\Select;
use JsonFormBuilder\JsonForm\FormFieldCollection;
use JsonFormBuilder\JsonForm\FormTextElementCollection;
use JsonFormBuilder\JsonResult;
use JsonFormBuilder\JsonResult\FormFieldValue\ArrayValue;
use JsonFormBuilder\JsonResult\FormFieldValue\BooleanValue;
use JsonFormBuilder\JsonResult\FormFieldValue\StringValue;
use JsonFormBuilder\JsonResult\FormFieldValueCollection;
use JsonFormBuilder\Service\StatisticBuilder;
use JsonFormBuilder\Tests\Stub\JsonFormCollection;
use JsonFormBuilder\Tests\Stub\JsonResultCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class StatisticBuilderTest extends TestCase
{
    /**
     * @var JsonFormCollection
     */
    private $jsonFormCollection;

    /**
     * @var JsonResultCollection
     */
    private $jsonResultCollection;

    /**
     * @var StatisticBuilder
     */
    private $statisticBuilder;

    protected function setUp(): void
    {
        $this->jsonFormCollection = new JsonFormCollection();
        $this->jsonResultCollection = new JsonResultCollection();
        $this->statisticBuilder = new StatisticBuilder(
            $this->jsonResultCollection,
            $this->jsonFormCollection,
            'Ja',
            'Nein'
        );
    }

    public function test_create_statistic(): void
    {
        $formId = Uuid::uuid4()->toString();
        $selectId = Uuid::uuid4()->toString();
        $checkboxId = Uuid::uuid4()->toString();
        $checkboxGroupId = Uuid::uuid4()->toString();

        $formFields = FormFieldCollection::emptyList()
            ->add(new Select(
                $selectId,
                'Select',
                1,
                OptionCollection::emptyList()
                    ->add(new Option('Probe A', 'A'))
                    ->add(new Option('Probe B', 'B'))
            ))
            ->add(new Checkbox($checkboxId, 'Checkbox', 2))
            ->add(new CheckboxGroup(
                $checkboxGroupId,
                'CheckboxGroup',
                3,
                OptionCollection::emptyList()
                    ->add(new Option('A', 'A'))
                    ->add(new Option('B', 'B'))
                    ->add(new Option('C', 'C'))
            ));

        $this->jsonFormCollection->save(new JsonForm($formId, $formFields, FormTextElementCollection::emptyList()));

        $values1 = FormFieldValueCollection::emptyList()
            ->add(new StringValue($selectId, 'A'))
            ->add(new BooleanValue($checkboxId, true))
            ->add(new ArrayValue($checkboxGroupId, ['A', 'B']));

        $this->jsonResultCollection->save(new JsonResult(Uuid::uuid4()->toString(), $formId, $values1));

        $values2 = FormFieldValueCollection::emptyList()
            ->add(new StringValue($selectId, 'B'))
            ->add(new BooleanValue($checkboxId, false))
            ->add(new ArrayValue($checkboxGroupId, ['A']));

        $this->jsonResultCollection->save(new JsonResult(Uuid::uuid4()->toString(), $formId, $values2));

        $values3 = FormFieldValueCollection::emptyList()
            ->add(new StringValue($selectId, 'C'))
            ->add(new BooleanValue($checkboxId, true))
            ->add(new ArrayValue($checkboxGroupId, []));

        $this->jsonResultCollection->save(new JsonResult(Uuid::uuid4()->toString(), $formId, $values3));

        $values4 = FormFieldValueCollection::emptyList()
            ->add(new StringValue($selectId, 'A'))
            ->add(new BooleanValue($checkboxId, true))
            ->add(new ArrayValue($checkboxGroupId, ['D']));

        $this->jsonResultCollection->save(new JsonResult(Uuid::uuid4()->toString(), $formId, $values4));

        $this->assertEquals([
            [
                'position' => 1,
                'label' => 'Select',
                'results' => 4,
                'countPerChoice' => [
                    'A' => ['label' => 'Probe A', 'count' => 2],
                    'B' => ['label' => 'Probe B', 'count' => 1],
                ]
            ],
            [
                'position' => 2,
                'label' => 'Checkbox',
                'results' => 4,
                'countPerChoice' => [
                    'true' => ['label' => 'Ja', 'count' => 3],
                    'false' => ['label' => 'Nein', 'count' => 1],
                ]
            ],
            [
                'position' => 3,
                'label' => 'CheckboxGroup',
                'results' => 4,
                'countPerChoice' => [
                    'A' => ['label' => 'A', 'count' => 2],
                    'B' => ['label' => 'B', 'count' => 1],
                    'C' => ['label' => 'C', 'count' => 0],
                ]
            ]
        ], $this->statisticBuilder->buildOptionStatistic($formId));
    }
}
