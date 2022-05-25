<?php

declare(strict_types=1);

namespace SharedKernel\Model\Exception;

use Exception;

use function array_merge;

abstract class AbstractException extends Exception implements ContextExceptionInterface
{
    private array $context = [];

    public function getContext(): array
    {
        return $this->context;
    }

    public function setContext(array $data, ?bool $merge = true): void
    {
        if ($merge) {
            $this->context = array_merge(
                $this->context,
                $data,
            );
        } else {
            $this->context = $data;
        }
    }
}
