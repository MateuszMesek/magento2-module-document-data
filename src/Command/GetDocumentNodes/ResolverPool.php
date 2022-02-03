<?php declare(strict_types=1);

namespace MateuszMesek\Document\Command\GetDocumentNodes;

use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;
use MateuszMesek\Document\Api\DocumentNodesResolverInterface;

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

    public function get(string $document): DocumentNodesResolverInterface
    {
        return $this->documents[$document];
    }
}
