<?php

declare(strict_types=1);

namespace SharedKernel\Model;

abstract class AbstractInteger
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
