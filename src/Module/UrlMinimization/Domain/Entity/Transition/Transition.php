<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Entity\Transition;

use UrlMinimization\Domain\Entity\MinifiedToken;

final class Transition
{
    private TransitionDateTime $dateTime;
    private MinifiedToken $minifiedToken;

    public function __construct(
        TransitionDateTime $dateTime,
        MinifiedToken $minifiedToken
    ) {
        $this->dateTime = $dateTime;
        $this->minifiedToken = $minifiedToken;
    }

    public function getDateTime(): TransitionDateTime
    {
        return $this->dateTime;
    }

    public function getMinifiedToken(): MinifiedToken
    {
        return $this->minifiedToken;
    }
}