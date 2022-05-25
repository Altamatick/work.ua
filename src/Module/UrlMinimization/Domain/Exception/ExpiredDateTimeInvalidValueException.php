<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Exception;

use SharedKernel\Model\Exception\AbstractException;

final class ExpiredDateTimeInvalidValueException extends AbstractException
{
    public static function build(string $value): self
    {
        $exception = new self('The expired date has invalid value');
        $exception->setContext(['rawValue' => $value]);

        return $exception;
    }
}