<?php

declare(strict_types=1);

namespace SharedKernel\Model\Exception;

interface ContextExceptionInterface
{
    public function getContext(): array;

    public function setContext(array $data, ?bool $merge = true): void;
}
