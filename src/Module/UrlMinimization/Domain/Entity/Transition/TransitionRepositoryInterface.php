<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Entity\Transition;

use UrlMinimization\Domain\Entity\MinifiedToken;
use UrlMinimization\Domain\Exception\Transition\TransitionSaveFailedException;

interface TransitionRepositoryInterface
{
    /**
     * @throws TransitionSaveFailedException
     */
    public function addTransition(Transition $transition): void;

    public function getTransitionsByMinifiedToken(MinifiedToken $minifiedToken): Transitions;
}