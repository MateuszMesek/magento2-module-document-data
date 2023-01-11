<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Command;

use Traversable;
use MateuszMesek\DocumentDataApi\Model\Command\GetDocumentNodesInterface;
use MateuszMesek\DocumentData\Model\Command\GetDocumentNodes\ResolverPool;

class GetDocumentNodes implements GetDocumentNodesInterface
{
    public function __construct(
        private readonly ResolverPool $resolverPool
    )
    {
    }

    public function execute(string $documentName): Traversable
    {
        yield from $this->resolverPool->get($documentName)->resolve();
    }
}
