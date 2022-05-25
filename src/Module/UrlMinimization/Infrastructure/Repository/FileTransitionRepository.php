<?php

declare(strict_types=1);

namespace UrlMinimization\Infrastructure\Repository;

use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use UrlMinimization\Domain\Entity\MinifiedToken;
use UrlMinimization\Domain\Entity\Transition\Transition;
use UrlMinimization\Domain\Entity\Transition\TransitionRepositoryInterface;
use UrlMinimization\Domain\Entity\Transition\Transitions;
use UrlMinimization\Domain\Exception\Transition\TransitionSaveFailedException;

final class FileTransitionRepository implements TransitionRepositoryInterface
{
    private const CACHE_PREFIX = 'transitions_';
    private FilesystemAdapter $filesystemAdapter;

    public function __construct(
        FilesystemAdapter $filesystemAdapter
    ) {
        $this->filesystemAdapter = $filesystemAdapter;
    }

    /**
     * @throws InvalidArgumentException
     * @throws TransitionSaveFailedException
     */
    public function addTransition(Transition $transition): void
    {
        $transitions = $this->getTransitionsByMinifiedToken($transition->getMinifiedToken());
        $transitions->add($transition);

        $item = $this->filesystemAdapter->getItem(self::CACHE_PREFIX . $transition->getMinifiedToken()->getValue());
        $item->set($transitions);
        if (!$this->filesystemAdapter->save($item)) {
            throw TransitionSaveFailedException::build();
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getTransitionsByMinifiedToken(MinifiedToken $minifiedToken): Transitions
    {
        return $this->filesystemAdapter->get(
            self::CACHE_PREFIX . $minifiedToken->getValue(),
            function (ItemInterface $item) {
                return new Transitions();
            }
        );
    }
}