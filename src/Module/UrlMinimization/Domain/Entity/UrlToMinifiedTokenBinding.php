<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Entity;

final class UrlToMinifiedTokenBinding
{
    private ExpiredDateTime $expiredDateTime;
    private MinifiedToken $minifiedToken;
    private Url $url;

    public function __construct(
        Url $url,
        MinifiedToken $minifiedToken,
        ExpiredDateTime $expiredDateTime
    ) {
        $this->url = $url;
        $this->minifiedToken = $minifiedToken;
        $this->expiredDateTime = $expiredDateTime;
    }

    public function getExpiredDateTime(): ExpiredDateTime
    {
        return $this->expiredDateTime;
    }

    public function getMinifiedToken(): MinifiedToken
    {
        return $this->minifiedToken;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }
}