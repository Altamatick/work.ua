<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Exception;

use SharedKernel\Model\Exception\AbstractException;
use Throwable;

final class MinifiedUrlFailedException extends AbstractException
{
    public static function build(Throwable $previous = null): self
    {
        return new self('Minified url failed', 0, $previous);
    }
}