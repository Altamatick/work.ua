<?php

declare(strict_types=1);

namespace UrlMinimization\Infrastructure\Service;

use Throwable;
use UrlMinimization\Domain\Entity\MinifiedToken;
use UrlMinimization\Domain\Entity\MinifiedTokenServiceInterface;
use UrlMinimization\Domain\Entity\Url;
use UrlMinimization\Domain\Exception\MinifiedUrlFailedException;

final class RandomBytesMinifiedTokenService implements MinifiedTokenServiceInterface
{
    /**
     * @throws MinifiedUrlFailedException
     */
    public function execute(Url $url): MinifiedToken
    {
        try {
            // 36^6=2 176 782 336  - unique options
            return new MinifiedToken(bin2hex(random_bytes(3)));
        } catch (Throwable $exception) {
            throw MinifiedUrlFailedException::build($exception);
        }
    }
}