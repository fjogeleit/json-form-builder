<?php

declare(strict_types=1);

namespace JsonFormBuilder\Tests\Stub;

use JsonFormBuilder\JsonForm;
use JsonFormBuilder\JsonFormCollectionInterface;

class JsonFormCollection implements JsonFormCollectionInterface
{
    /**
     * @var array|JsonForm[]
     */
    protected $forms = [];

    public function save(JsonForm $jsonForm): void
    {
        $this->forms[$jsonForm->jsonFormId()] = $jsonForm;
    }

    public function get(string $jsonFormId): JsonForm
    {
        return $this->forms[$jsonFormId];
    }
}
