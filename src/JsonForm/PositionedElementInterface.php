<?php

declare(strict_types=1);

namespace JsonFormBuilder\JsonForm;

interface PositionedElementInterface
{
    public function position(): int;
}
