<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Entity;

use UrlMinimization\Domain\Entity\ExpiredDateTime;
use UrlMinimization\Domain\Entity\Url;

final class MinifiedRequest
{
    private ExpiredDateTime $expiredDateTime;
    private Url $url;

    public function __construct(
        Url $url,
        ExpiredDateTime $expiredDateTime
    ) {
        $this->url = $url;
        $this->expiredDateTime = $expiredDateTime;
    }

    public function getExpiredDateTime(): ExpiredDateTime
    {
        return $this->expiredDateTime;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }
}