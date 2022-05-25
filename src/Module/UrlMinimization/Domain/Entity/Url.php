<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Entity;

use SharedKernel\Model\AbstractString;
use UrlMinimization\Domain\Exception\UrlInvalidValueException;

final class Url extends AbstractString
{
    /**
     * @throws UrlInvalidValueException
     */
    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw UrlInvalidValueException::build($value);
        }
        parent::__construct($value);
    }
}