<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Exception;

use SharedKernel\Model\Exception\AbstractException;
use Throwable;

final class MinimizationSaveFailedException extends AbstractException
{
    public static function build(Throwable $previous = null): self
    {
        return new self('Minimization save failed', 0, $previous);
    }
}