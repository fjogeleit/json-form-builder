<?php

declare(strict_types=1);

namespace JsonFormBuilder\Service;

use JsonFormBuilder\JsonForm\FormFieldCollection;
use JsonFormBuilder\JsonForm\FormFieldInterface;
use JsonFormBuilder\JsonResult\FormFieldValueCollection;

class FormFieldValueCollectionFactory
{
    /**
     * @var iterable|FormFieldValueFactoryInterface[]
     */
    private $factories;

    public function __construct(iterable $factories)
    {
        $this->factories = $factories;
    }

    public function createFromCollection(FormFieldCollection $fieldCollection): FormFieldValueCollection
    {
        $values = FormFieldValueCollection::emptyList();

        /** @var FormFieldInterface $formField */
        foreach ($fieldCollection as $formField) {
            foreach ($this->factories as $factory) {
                if (false === $factory->supports($formField)) {
                    continue;
                }

                $values = $values->add($factory->createFromFormField($formField));
            }
        }

        return $values;
    }
}
