<?php

declare(strict_types=1);

namespace JsonFormBuilder\Service;

use JsonFormBuilder\Exception\InvalidStatisticFormType;
use JsonFormBuilder\JsonForm\Exception\ValueNotExistsInOptions;
use JsonFormBuilder\JsonForm\FormField;
use JsonFormBuilder\JsonForm\FormField\BooleanFormFieldInterface;
use JsonFormBuilder\JsonForm\FormField\MultiOptionFormFieldInterface;
use JsonFormBuilder\JsonForm\FormField\Option;
use JsonFormBuilder\JsonForm\FormField\SingleOptionFormFieldInterface;
use JsonFormBuilder\JsonForm\FormFieldType;
use JsonFormBuilder\JsonFormCollectionInterface;
use JsonFormBuilder\JsonResult;
use JsonFormBuilder\JsonResult\FormFieldValue\ArrayValue;
use JsonFormBuilder\JsonResult\FormFieldValue\BooleanValue;
use JsonFormBuilder\JsonResult\FormFieldValue\StringValue;
use JsonFormBuilder\JsonResult\Service\JsonResultFinderInterface;

class StatisticBuilder
{
    private const OPTION_FIELDS = [
        FormFieldType::CHECKBOX,
        FormFieldType::CHECKBOX_GROUP,
        FormFieldType::RADIO_BUTTON,
        FormFieldType::RADIO_BUTTON_GROUP,
        FormFieldType::SELECT,
        FormFieldType::MULTI_SELECT,
    ];

    /**
     * @var JsonResultFinderInterface
     */
    private $jsonResultFinder;

    /**
     * @var JsonFormCollectionInterface
     */
    private $jsonFormCollection;

    /**
     * @var string
     */
    private $trueLabel;

    /**
     * @var string
     */
    private $falseLabel;

    public function __construct(
        JsonResultFinderInterface $jsonResultFinder,
        JsonFormCollectionInterface $jsonFormCollection,
        string $trueLabel = 'true',
        string $falseLabel = 'false'
    ) {
        $this->jsonResultFinder = $jsonResultFinder;
        $this->jsonFormCollection = $jsonFormCollection;
        $this->trueLabel = $trueLabel;
        $this->falseLabel = $falseLabel;
    }

    public function buildOptionStatistic(string $jsonFormId): array
    {
        $form = $this->jsonFormCollection->get($jsonFormId);
        $results = $this->jsonResultFinder->findByFormId($jsonFormId);

        $statisticFields = $form->formFields()->filter(function (FormField $formField) {
            return true === in_array($formField->formFieldType()->toString(), self::OPTION_FIELDS);
        });

        return $statisticFields
            ->map(function (FormField $formField) use ($results) {
                if ($formField instanceof BooleanFormFieldInterface) {
                    return $this->mapBooleanValue($formField, $results);
                }

                if ($formField instanceof MultiOptionFormFieldInterface) {
                    return $this->mapMultipleValue($formField, $results);
                }

                if ($formField instanceof SingleOptionFormFieldInterface) {
                    return $this->mapSingleValue($formField, $results);
                }

                throw InvalidStatisticFormType::forType($formField->formFieldType());
            });
    }

    /**
     * @param BooleanFormFieldInterface $formField
     * @param JsonResult[]              $results
     *
     * @return array
     */
    private function mapBooleanValue(BooleanFormFieldInterface $formField, array $results): array
    {
        $result = [
            'position' => $formField->position(),
            'label' => $formField->label(),
            'results' => count($results),
            'countPerChoice' => [
                'true' => [
                    'label' => $this->trueLabel,
                    'count' => 0,
                ],
                'false' => [
                    'label' => $this->falseLabel,
                    'count' => 0,
                ]
            ]
        ];

        foreach ($results as $jsonResult) {
            $value = $jsonResult->getValue($formField->formFieldId());

            if (false === $value instanceof BooleanValue) {
                continue;
            }

            $count = $result['countPerChoice'][$value->toString()]['count'];

            $result['countPerChoice'][$value->toString()]['count'] = ++$count;
        }

        return $result;
    }

    /**
     * @param SingleOptionFormFieldInterface $formField
     * @param JsonResult[]                   $results
     *
     * @return array
     */
    private function mapSingleValue(SingleOptionFormFieldInterface $formField, array $results): array
    {
        $result = [
            'position' => $formField->position(),
            'label' => $formField->label(),
            'results' => count($results),
            'countPerChoice' => $formField->options()->reduce(function (array $options, Option $option) {
                $options[$option->value()] = [
                    'label' => $option->label(),
                    'count' => 0
                ];

                return $options;
            }, [])
        ];

        foreach ($results as $jsonResult) {
            $value = $jsonResult->getValue($formField->formFieldId());

            if (false === $value instanceof StringValue) {
                continue;
            }

            if (true === $value->isEmpty()) {
                continue;
            }

            try {
                $formField->validateValue($value);

                $count = $result['countPerChoice'][$value->toString()]['count'];

                $result['countPerChoice'][$value->toString()]['count'] = ++$count;
            } catch (ValueNotExistsInOptions $exception) {
                continue;
            }
        }

        return $result;
    }

    /**
     * @param MultiOptionFormFieldInterface $formField
     * @param JsonResult[]                  $results
     *
     * @return array
     */
    private function mapMultipleValue(MultiOptionFormFieldInterface $formField, array $results): array
    {
        $result = [
            'position' => $formField->position(),
            'label' => $formField->label(),
            'results' => count($results),
            'countPerChoice' => $formField->options()->reduce(function (array $options, Option $option) {
                $options[$option->value()] = [
                    'label' => $option->label(),
                    'count' => 0
                ];

                return $options;
            }, [])
        ];

        foreach ($results as $jsonResult) {
            $value = $jsonResult->getValue($formField->formFieldId());

            if (false === $value instanceof ArrayValue) {
                continue;
            }

            foreach ($value->value() as $option) {
                if (false === $formField->options()->hasValue($option)) {
                    continue;
                }

                $count = $result['countPerChoice'][$option]['count'];

                $result['countPerChoice'][$option]['count'] = ++$count;
            }
        }

        return $result;
    }
}
