<?php

declare(strict_types=1);

namespace SharedKernel\Model\Collection;

use function count;
use function current;
use function key;
use function next;
use function reset;

abstract class AbstractCollection implements CollectionInterface
{
    protected array $items = [];

    public function __construct(?array $items = null)
    {
        if (null !== $items) {
            foreach ($items as $item) {
                $this->add($item);
            }
        }
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return false|mixed
     */
    public function current()
    {
        return current($this->items);
    }

    public function first()
    {
        $this->rewind();

        return $this->current();
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * @return float|int|string|null
     */
    public function key()
    {
        return key($this->items);
    }

    public function next(): void
    {
        next($this->items);
    }

    public function rewind(): void
    {
        reset($this->items);
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function valid(): bool
    {
        return null !== $this->key();
    }
}
