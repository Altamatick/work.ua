<?php

declare(strict_types=1);

namespace UrlMinimization\Domain\Entity;

use UrlMinimization\Domain\Exception\MinimizationSaveFailedException;

interface UrlRepositoryInterface
{
    public function findByMinifiedToken(MinifiedToken $minifiedToken): ?UrlToMinifiedTokenBinding;

    /**
     * @throws MinimizationSaveFailedException
     */
    public function save(UrlToMinifiedTokenBinding $request): void;
}