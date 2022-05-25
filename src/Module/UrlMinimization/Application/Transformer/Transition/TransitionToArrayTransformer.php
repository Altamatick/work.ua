<?php

declare(strict_types=1);

namespace UrlMinimization\Application\Transformer\Transition;

use UrlMinimization\Domain\Entity\Transition\Transition;
use UrlMinimization\Domain\Entity\Transition\Transitions;

final class TransitionToArrayTransformer
{
    public function transformCollection(Transitions $transitions): array
    {
        $response = [];
        foreach ($transitions as $transition) {
            $response[] = $this->transform($transition);
        }

        return $response;
    }

    private function transform(Transition $transition): array
    {
        return [
            'date' => $transition->getDateTime()->format('Y-m-d H:i:s'),
            'token' => $transition->getMinifiedToken()->getValue(),
        ];
    }
}