<?php

declare(strict_types=1);

namespace UrlMinimization\Application\Service;

use SharedKernel\Logger\LoggerInterface;
use SharedKernel\Model\Exception\UnexpectedSituationException;
use Throwable;
use UrlMinimization\Domain\Entity\MinifiedToken;
use UrlMinimization\Domain\Entity\Transition\Transition;
use UrlMinimization\Domain\Entity\Transition\TransitionRepositoryInterface;
use UrlMinimization\Domain\Entity\Transition\Transitions;
use UrlMinimization\Domain\Exception\Transition\TransitionSaveFailedException;

final class StatisticService
{
    private LoggerInterface $logger;
    private TransitionRepositoryInterface $transactionRepository;

    public function __construct(
        TransitionRepositoryInterface $transactionRepository,
        LoggerInterface $logger
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->logger = $logger;
    }

    /**
     * @throws UnexpectedSituationException
     * @throws TransitionSaveFailedException
     */
    public function addTransition(Transition $transaction): void
    {
        try {
            $this->transactionRepository->addTransition($transaction);

            return;
        } catch (TransitionSaveFailedException $exception ) {
            $this->logger->errorException($exception);
        } catch (Throwable $exception) {
            $this->logger->errorException($exception);
            $exception = UnexpectedSituationException::build($exception);
        }

        throw $exception;
    }

    /**
     * @throws UnexpectedSituationException
     */
    public function getTransitionsByMinifiedToken(MinifiedToken $minifiedToken): Transitions
    {
        try {
            return $this->transactionRepository->getTransitionsByMinifiedToken($minifiedToken);
        } catch (Throwable $exception) {
            $this->logger->errorException($exception);
            $exception = UnexpectedSituationException::build($exception);
        }

        throw $exception;
    }
}