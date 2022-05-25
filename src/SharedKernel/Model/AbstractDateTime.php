<?php

declare(strict_types=1);

namespace SharedKernel\Model;

use DateTime;

abstract class AbstractDateTime extends DateTime
{
    private const NOW = 'now';

    public static function buildNow()
    {
        return new static(self::NOW);
    }

    public function isLessThan(self $dateTime): bool
    {
        return $this < $dateTime;
    }
}
