<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Exception\Transition;

use SharedKernel\Model\Exception\AbstractException;

final class TransitionDateTimeInvalidValueException extends AbstractException
{
    public static function build(string $value): self
    {
        $exception = new self('The transition date has invalid value');
        $exception->setContext(['rawValue' => $value]);

        return $exception;
    }
}