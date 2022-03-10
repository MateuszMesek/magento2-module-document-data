<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Command;

use Traversable;
use MateuszMesek\DocumentDataApi\Command\GetDocumentNodesInterface;
use MateuszMesek\DocumentData\Command\GetDocumentNodes\ResolverPool;

class GetDocumentNodes implements GetDocumentNodesInterface
{
    private ResolverPool $resolverPool;

    public function __construct(
        ResolverPool $resolverPool
    )
    {
        $this->resolverPool = $resolverPool;
    }

    public function execute(string $documentName): Traversable
    {
        yield from $this->resolverPool->get($documentName)->resolve();
    }
}
