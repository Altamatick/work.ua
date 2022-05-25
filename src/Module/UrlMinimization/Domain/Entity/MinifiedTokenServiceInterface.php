<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Entity;

use UrlMinimization\Domain\Exception\MinifiedUrlFailedException;

interface MinifiedTokenServiceInterface
{
    /**
     * @throws MinifiedUrlFailedException
     */
    public function execute(Url $url): MinifiedToken;
}