<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Entity;

use SharedKernel\Model\AbstractString;
use UrlMinimization\Domain\Exception\MinifiedTokenInvalidValueException;

final class MinifiedToken extends AbstractString
{
    private const MIN_VALUE = 6;
    /**
     * @throws MinifiedTokenInvalidValueException
     */
    public function __construct(string $value)
    {
        if (strlen($value) < self::MIN_VALUE) {
            throw MinifiedTokenInvalidValueException::build($value);
        }
        parent::__construct($value);
    }
}