<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Command\GetDocumentNodes;

use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;
use MateuszMesek\DocumentDataApi\DocumentNodesResolverInterface;

class ResolverPool
{
    private TMap $documents;

    public function __construct(
        TMapFactory $TMapFactory,
        array $documents
    )
    {
        $this->documents = $TMapFactory->createSharedObjectsMap([
            'type' => DocumentNodesResolverInterface::class,
            'array' => $documents
        ]);
    }

    public function get(string $documentName): DocumentNodesResolverInterface
    {
        return $this->documents[$documentName];
    }
}
