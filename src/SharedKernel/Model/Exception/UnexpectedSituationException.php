<?php

declare(strict_types=1);

namespace SharedKernel\Model\Exception;

use Throwable;

final class UnexpectedSituationException extends AbstractException
{
    public static function build(Throwable $previous = null): self
    {
        return new self('Unexpected situation', 0, $previous);
    }
}
