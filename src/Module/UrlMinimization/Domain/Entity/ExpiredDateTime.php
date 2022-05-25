<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Entity;

use DateTimeZone;
use SharedKernel\Model\AbstractDateTime;
use Throwable;
use UrlMinimization\Domain\Exception\ExpiredDateTimeInvalidValueException;

final class ExpiredDateTime extends AbstractDateTime
{
    /**
     * @throws ExpiredDateTimeInvalidValueException
     */
    public function __construct($datetime = 'now', DateTimeZone $timezone = null)
    {
        try {
            parent::__construct($datetime, $timezone);
        } catch (Throwable $exception) {
            throw ExpiredDateTimeInvalidValueException::build($datetime);
        }
    }

    public function isExpired(): bool
    {
        return $this->isLessThan(self::buildNow());
    }
}