<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Service;

use UrlMinimization\Domain\Entity\ExpiredDateTime;
use UrlMinimization\Domain\Entity\MinifiedRequest;
use UrlMinimization\Domain\Entity\MinifiedTokenServiceInterface;
use UrlMinimization\Domain\Entity\Request\SaveRequest;
use UrlMinimization\Domain\Entity\UrlRepositoryInterface;
use UrlMinimization\Domain\Entity\UrlToMinifiedTokenBinding;
use UrlMinimization\Domain\Exception\ExpiredDateTimeLessThenCurrentOneException;
use UrlMinimization\Domain\Exception\MinifiedUrlFailedException;
use UrlMinimization\Domain\Exception\MinimizationSaveFailedException;

final class MinifiedUrlGenerateService
{
    private MinifiedTokenServiceInterface $minifiedUrlService;
    private UrlRepositoryInterface $urlRepository;

    public function __construct(
        MinifiedTokenServiceInterface $minifiedUrlService,
        UrlRepositoryInterface $urlRepository
    ) {
        $this->urlRepository = $urlRepository;
        $this->minifiedUrlService = $minifiedUrlService;
    }

    /**
     * @throws ExpiredDateTimeLessThenCurrentOneException
     * @throws MinimizationSaveFailedException
     * @throws MinifiedUrlFailedException
     */
    public function byMinifiedRequest(MinifiedRequest $minifiedRequest): UrlToMinifiedTokenBinding
    {
        if ($minifiedRequest->getExpiredDateTime()->isLessThan(ExpiredDateTime::buildNow())) {
            throw ExpiredDateTimeLessThenCurrentOneException::build();
        }
        $urlToMinifiedTokenBinding = new UrlToMinifiedTokenBinding(
            $minifiedRequest->getUrl(),
            $this->minifiedUrlService->execute($minifiedRequest->getUrl()),
            $minifiedRequest->getExpiredDateTime(),
        );
        $this->urlRepository->save($urlToMinifiedTokenBinding);

        return $urlToMinifiedTokenBinding;
    }
}