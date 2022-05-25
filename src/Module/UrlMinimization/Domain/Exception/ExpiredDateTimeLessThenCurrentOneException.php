<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Exception;

use SharedKernel\Model\Exception\AbstractException;

final class ExpiredDateTimeLessThenCurrentOneException extends AbstractException
{
    public static function build(): self
    {
        return new self('The expired date is less than the current one');
    }
}