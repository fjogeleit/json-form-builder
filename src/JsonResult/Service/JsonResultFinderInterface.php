<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonResult\Service;

use JsonFormBuilder\JsonResult;

interface JsonResultFinderInterface
{
    /**
     * @param string $formId
     *
     * @return array|JsonResult[]
     */
    public function findByFormId(string $formId): array;
}
