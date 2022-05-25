<?php

declare(strict_types=1);

namespace SharedKernel\Logger;

use Psr\Log\LoggerInterface as PsrLoggerInterface;
use Throwable;

interface LoggerInterface extends PsrLoggerInterface
{
    public function errorException(Throwable $exception, ?array $contextData = null): void;

    public function infoException(Throwable $exception, ?array $contextData = null): void;

    public function warningException(Throwable $exception, ?array $contextData = null): void;
}
