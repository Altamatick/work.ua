<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Exception;

use SharedKernel\Model\Exception\AbstractException;

final class MinifiedTokenInvalidValueException extends AbstractException
{
    public static function build(string $value): self
    {
        $exception = new self('Minified token has invalid value');
        $exception->setContext(['rawValue' => $value]);

        return $exception;
    }
}