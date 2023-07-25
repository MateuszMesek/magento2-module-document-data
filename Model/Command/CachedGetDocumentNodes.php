<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Command;

use Traversable;
use MateuszMesek\DocumentDataApi\Model\Command\GetDocumentNodesInterface;

class CachedGetDocumentNodes implements GetDocumentNodesInterface
{
    private array $documentNodesByDocumentName = [];

    public function __construct(
        private readonly GetDocumentNodesInterface $getDocumentNodes
    )
    {
    }

    public function execute(string $documentName): Traversable
    {
        if (!array_key_exists($documentName, $this->documentNodesByDocumentName)) {
            $this->documentNodesByDocumentName[$documentName] = iterator_to_array(
                $this->getDocumentNodes->execute($documentName)
            );
        }

        yield from $this->documentNodesByDocumentName[$documentName];
    }
}
