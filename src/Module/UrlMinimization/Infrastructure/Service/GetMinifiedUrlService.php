<?php

declare(strict_types=1);

namespace UrlMinimization\Infrastructure\Service;

use UrlMinimization\Domain\Entity\GetMinifiedUrlServiceInterface;
use UrlMinimization\Domain\Entity\MinifiedToken;
use UrlMinimization\Domain\Entity\Url;
use UrlMinimization\Domain\Exception\UrlInvalidValueException;

final class GetMinifiedUrlService implements GetMinifiedUrlServiceInterface
{
    private string $host;
    private ?string $port;
    private string $protocol;

    public function __construct(
        string $protocol,
        string $host,
        ?string $port = null
    ) {
        $this->protocol = $protocol;
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @throws UrlInvalidValueException
     */
    public function execute(MinifiedToken $minifiedToken): Url
    {
        return new Url(
            sprintf(
                '%s://%s%s/%s',
                $this->protocol,
                $this->host,
                null !== $this->port
                    ? ':' . $this->port
                    : '',
                $minifiedToken->getValue(),
            )
        );
    }
}