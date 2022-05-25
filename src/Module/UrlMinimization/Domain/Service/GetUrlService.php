<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Service;

use UrlMinimization\Domain\Entity\MinifiedToken;
use UrlMinimization\Domain\Entity\UrlToMinifiedTokenBinding;
use UrlMinimization\Domain\Entity\UrlRepositoryInterface;
use UrlMinimization\Domain\Exception\UrlExpiredException;
use UrlMinimization\Domain\Exception\UrlNotFoundException;

final class GetUrlService
{
    private UrlRepositoryInterface $urlRepository;

    public function __construct(
        UrlRepositoryInterface $urlRepository
    ) {
        $this->urlRepository = $urlRepository;
    }

    /**
     * @throws UrlExpiredException
     * @throws UrlNotFoundException
     */
    public function getByMinifiedToken(MinifiedToken $minifiedToken): UrlToMinifiedTokenBinding
    {
        $response = $this->urlRepository->findByMinifiedToken($minifiedToken);
        if (null === $response) {
            throw UrlNotFoundException::build($minifiedToken->getValue());
        }
        if ($response->getExpiredDateTime()->isExpired()) {
            throw UrlExpiredException::build();
        }

        return $response;
    }
}