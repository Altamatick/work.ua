<?php

declare(strict_types=1);

namespace UrlMinimization\Application\Service;

use SharedKernel\Logger\LoggerInterface;
use SharedKernel\Model\Exception\UnexpectedSituationException;
use Throwable;
use UrlMinimization\Domain\Entity\GetMinifiedUrlServiceInterface;
use UrlMinimization\Domain\Entity\MinifiedToken;
use UrlMinimization\Domain\Entity\Url;
use UrlMinimization\Domain\Entity\UrlToMinifiedTokenBinding;
use UrlMinimization\Domain\Exception\UrlExpiredException;
use UrlMinimization\Domain\Exception\UrlNotFoundException;
use UrlMinimization\Domain\Service\GetUrlService as GetUrlDomainService;

final class GetUrlService
{
    private GetMinifiedUrlServiceInterface $getMinifiedUrlService;
    private GetUrlDomainService $getUrlService;
    private LoggerInterface $logger;

    public function __construct(
        GetUrlDomainService $getUrlService,
        GetMinifiedUrlServiceInterface $getMinifiedUrlService,
        LoggerInterface $logger
    ) {
        $this->getUrlService = $getUrlService;
        $this->logger = $logger;
        $this->getMinifiedUrlService = $getMinifiedUrlService;
    }

    /**
     * @throws UrlExpiredException
     * @throws UrlNotFoundException
     * @throws UnexpectedSituationException
     */
    public function getByMinifiedToken(MinifiedToken $minifiedToken): UrlToMinifiedTokenBinding
    {
        try {
            return $this->getUrlService->getByMinifiedToken($minifiedToken);
        } catch (UrlExpiredException|UrlNotFoundException $exception) {
            $this->logger->infoException($exception);
        } catch (Throwable $exception) {
            $this->logger->errorException($exception);
            $exception = UnexpectedSituationException::build($exception);
        }

        throw $exception;
    }

    /**
     * @throws UnexpectedSituationException
     */
    public function getMinifiedUrlByMinifiedToken(MinifiedToken $minifiedToken): Url
    {
        try {
            return $this->getMinifiedUrlService->execute($minifiedToken);
        } catch (Throwable $exception) {
            $this->logger->errorException($exception);
            $exception = UnexpectedSituationException::build($exception);
        }

        throw $exception;
    }
}