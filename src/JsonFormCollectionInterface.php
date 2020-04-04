<?php

declare(strict_types=1);

namespace JsonFormBuilder;

interface JsonFormCollectionInterface
{
    public function save(JsonForm $jsonForm): void;
    public function get(string $jsonFormId): JsonForm;
}
