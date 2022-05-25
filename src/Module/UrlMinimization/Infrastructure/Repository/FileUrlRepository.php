<?php

declare(strict_types=1);

namespace UrlMinimization\Infrastructure\Repository;

use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use UrlMinimization\Domain\Entity\MinifiedToken;
use UrlMinimization\Domain\Entity\UrlRepositoryInterface;
use UrlMinimization\Domain\Entity\UrlToMinifiedTokenBinding;
use UrlMinimization\Domain\Exception\MinimizationSaveFailedException;

final class FileUrlRepository implements UrlRepositoryInterface
{
    private const CACHE_PREFIX = 'entity_';
    private FilesystemAdapter $filesystemAdapter;

    public function __construct(
        FilesystemAdapter $filesystemAdapter
    ) {
        $this->filesystemAdapter = $filesystemAdapter;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findByMinifiedToken(MinifiedToken $minifiedToken): ?UrlToMinifiedTokenBinding
    {
        return $this->filesystemAdapter->get(
            self::CACHE_PREFIX . $minifiedToken->getValue(),
            function (ItemInterface $item) {
                return null;
            }
        );

    }

    /**
     * @throws MinimizationSaveFailedException
     * @throws InvalidArgumentException
     */
    public function save(UrlToMinifiedTokenBinding $request): void
    {
        $item = $this->filesystemAdapter->getItem(self::CACHE_PREFIX . $request->getMinifiedToken()->getValue());
        $item->set($request);
        if (!$this->filesystemAdapter->save($item)) {
            throw MinimizationSaveFailedException::build();
        }
    }
}