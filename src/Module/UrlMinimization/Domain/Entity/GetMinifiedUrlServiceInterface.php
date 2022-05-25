<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Entity;

interface GetMinifiedUrlServiceInterface
{
    public function execute(MinifiedToken $minifiedToken): Url;
}