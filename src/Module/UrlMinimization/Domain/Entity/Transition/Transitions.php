<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Entity\Transition;

use SharedKernel\Model\Collection\AbstractCollection;

/**
 * @method Transition current()
 */
final class Transitions extends AbstractCollection
{
    public function add(Transition $transition): void
    {
        $this->items[] = $transition;
    }
}