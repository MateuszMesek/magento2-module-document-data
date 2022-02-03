<?php declare(strict_types=1);

namespace MateuszMesek\Document\Command;

use Generator;
use MateuszMesek\Document\Api\Command\GetDocumentNodesInterface;
use MateuszMesek\Document\Command\GetDocumentNodes\ResolverPool;

class GetDocumentNodes implements GetDocumentNodesInterface
{
    private ResolverPool $resolverPool;

    public function __construct(
        ResolverPool $resolverPool
    )
    {
        $this->resolverPool = $resolverPool;
    }

    public function execute(string $document): Generator
    {
        yield from $this->resolverPool->get($document)->resolve();
    }
}
