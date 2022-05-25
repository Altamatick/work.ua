<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Entity\Transition;

use DateTimeZone;
use SharedKernel\Model\AbstractDateTime;
use Throwable;
use UrlMinimization\Domain\Exception\Transition\TransitionDateTimeInvalidValueException;

final class TransitionDateTime extends AbstractDateTime
{
    /**
     * @throws TransitionDateTimeInvalidValueException
     */
    public function __construct($datetime = 'now', DateTimeZone $timezone = null)
    {
        try {
            parent::__construct($datetime, $timezone);
        } catch (Throwable $exception) {
            throw TransitionDateTimeInvalidValueException::build($datetime);
        }
    }
}