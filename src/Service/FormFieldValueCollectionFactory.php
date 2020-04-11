<?php

declare(strict_types=1);

namespace JsonFormBuilder\Service;

use JsonFormBuilder\JsonForm\FormFieldCollection;
use JsonFormBuilder\JsonForm\FormFieldInterface;
use JsonFormBuilder\JsonResult\FormFieldValueCollection;
use JsonFormBuilder\JsonResult\FormFieldValueInterface;

class FormFieldValueCollectionFactory
{
    /**
     * @var iterable|FormFieldValueFactoryInterface[]
     */
    private $factories;

    /**
     * @var iterable|FormFieldValueFactoryInterface[]
     */
    private $primitiveFactories;

    public function __construct(iterable $factories, iterable $primitiveFactories)
    {
        $this->factories = $factories;
        $this->primitiveFactories = $primitiveFactories;
    }

    public function createFromCollection(FormFieldCollection $fieldCollection): FormFieldValueCollection
    {
        $values = FormFieldValueCollection::emptyList();

        /** @var FormFieldInterface $formField */
        foreach ($fieldCollection as $formField) {
            $value = $this->createFormFieldValue($formField);

            if ($value instanceof FormFieldValueInterface) {
                $values = $values->add($value);
            }
        }

        return $values;
    }

    private function createFormFieldValue(FormFieldInterface $formField): ?FormFieldValueInterface
    {
        foreach ($this->factories as $factory) {
            if (true === $factory->supports($formField)) {
                return $factory->createFromFormField($formField);
            }
        }

        foreach ($this->primitiveFactories as $factory) {
            if (true === $factory->supports($formField)) {
                return $factory->createFromFormField($formField);
            }
        }

        return null;
    }
}
