<?php

declare(strict_types=1);

namespace SharedKernel\Model\Collection;

use Iterator;

interface CollectionInterface extends Iterator
{
    public function count(): int;

    public function isEmpty(): bool;
}
