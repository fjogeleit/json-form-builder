<?php

declare(strict_types=1);

namespace JsonFormBuilder;

interface JsonResultCollectionInterface
{
    public function save(JsonResult $jsonForm): void;
    public function get(string $jsonResultId): JsonResult;
}
