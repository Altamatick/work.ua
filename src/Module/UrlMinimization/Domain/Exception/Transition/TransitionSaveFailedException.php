<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Exception\Transition;

use SharedKernel\Model\Exception\AbstractException;
use Throwable;

final class TransitionSaveFailedException extends AbstractException
{
    public static function build(Throwable $previous = null): self
    {
        return new self('Transition save failed', 0, $previous);
    }
}