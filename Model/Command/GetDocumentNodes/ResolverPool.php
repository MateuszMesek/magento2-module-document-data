<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Command\GetDocumentNodes;

use InvalidArgumentException;
use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;
use MateuszMesek\DocumentDataApi\Model\DocumentNodesResolverInterface;

class ResolverPool
{
    private TMap $documents;

    public function __construct(
        TMapFactory $TMapFactory,
        array       $documents
    )
    {
        $this->documents = $TMapFactory->createSharedObjectsMap([
            'type' => DocumentNodesResolverInterface::class,
            'array' => $documents
        ]);
    }

    public function get(string $documentName): DocumentNodesResolverInterface
    {
        $resolver = $this->documents[$documentName];

        if (!$resolver instanceof DocumentNodesResolverInterface) {
            throw new InvalidArgumentException("Document data '$documentName' are without nodes");
        }

        return $resolver;
    }
}
