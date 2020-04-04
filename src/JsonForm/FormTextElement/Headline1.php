<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm\FormTextElement;

use Assert\Assertion;
use JsonFormBuilder\JsonForm\FormTextElement;
use JsonFormBuilder\JsonForm\FormTextElementType;

class Headline1 extends FormTextElement
{
    public function __construct(string $formTextElementId, string $text, int $position)
    {
        parent::__construct($formTextElementId, FormTextElementType::HEADLINE_1(), $text, $position);
    }

    public static function fromArray(array $data): FormTextElement
    {
        self::validate($data);

        return new self(
            $data['formTextElementId'],
            $data['text'],
            $data['position'],
        );
    }

    public static function validate(array $data): void
    {
        Assertion::keyExists($data, 'formTextElementId');
        Assertion::uuid($data['formTextElementId']);

        Assertion::keyExists($data, 'text');
        Assertion::string($data['text']);

        Assertion::keyExists($data, 'position');
        Assertion::integer($data['position']);
    }
}
