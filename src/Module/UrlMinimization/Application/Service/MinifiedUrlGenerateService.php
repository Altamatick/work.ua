<?php

declare(strict_types=1);

namespace UrlMinimization\Application\Service;

use SharedKernel\Logger\LoggerInterface;
use SharedKernel\Model\Exception\UnexpectedSituationException;
use Throwable;
use UrlMinimization\Domain\Entity\MinifiedRequest;
use UrlMinimization\Domain\Entity\UrlToMinifiedTokenBinding;
use UrlMinimization\Domain\Exception\ExpiredDateTimeLessThenCurrentOneException;
use UrlMinimization\Domain\Exception\MinifiedUrlFailedException;
use UrlMinimization\Domain\Exception\MinimizationSaveFailedException;
use UrlMinimization\Domain\Service\MinifiedUrlGenerateService as MinifiedUrlGenerateDomainService;

final class MinifiedUrlGenerateService
{
    private LoggerInterface $logger;
    private MinifiedUrlGenerateDomainService $minifiedUrlGenerateService;

    public function __construct(
        MinifiedUrlGenerateDomainService $minifiedUrlGenerateService,
        LoggerInterface $logger
    ) {
        $this->minifiedUrlGenerateService = $minifiedUrlGenerateService;
        $this->logger = $logger;
    }

    /**
     * @throws ExpiredDateTimeLessThenCurrentOneException
     * @throws MinifiedUrlFailedException
     * @throws MinimizationSaveFailedException
     * @throws UnexpectedSituationException
     */
    public function buildByRequest(MinifiedRequest $request): UrlToMinifiedTokenBinding
    {
        try {
            return $this->minifiedUrlGenerateService->byMinifiedRequest($request);
        } catch (
            ExpiredDateTimeLessThenCurrentOneException
            | MinimizationSaveFailedException
            | MinifiedUrlFailedException $exception
        ) {
            $this->logger->infoException($exception);
        } catch (Throwable $exception) {
            $this->logger->errorException($exception);
            $exception = UnexpectedSituationException::build($exception);
        }
        
        throw $exception;
    }
}