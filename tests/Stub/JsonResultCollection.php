<?php

declare(strict_types=1);

namespace JsonFormBuilder\Tests\Stub;

use JsonFormBuilder\JsonResult;
use JsonFormBuilder\JsonResult\Service\JsonResultFinderInterface;
use JsonFormBuilder\JsonResultCollectionInterface;

class JsonResultCollection implements JsonResultCollectionInterface, JsonResultFinderInterface
{
    /**
     * @var array|JsonResult[]
     */
    protected $forms = [];

    public function save(JsonResult $jsonResult): void
    {
        $this->forms[$jsonResult->jsonResultId()] = $jsonResult;
    }

    public function get(string $jsonResultId): JsonResult
    {
        return $this->forms[$jsonResultId];
    }

    public function findByFormId(string $formId): array
    {
        return array_filter($this->forms, function (JsonResult $jsonResult) use ($formId) {
            return $jsonResult->jsonFormId() === $formId;
        });
    }
}
