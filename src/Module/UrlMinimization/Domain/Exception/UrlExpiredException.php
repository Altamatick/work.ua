<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Exception;

use SharedKernel\Model\Exception\AbstractException;

final class UrlExpiredException extends AbstractException
{
    public static function build(): self
    {
        return new self('Url expired');
    }
}