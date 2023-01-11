<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Command\GetDocumentNodes;

use Generator;
use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;
use MateuszMesek\DocumentDataApi\Model\DocumentNodesResolverInterface;

class CompositeResolver implements DocumentNodesResolverInterface
{
    private TMap $resolvers;

    public function __construct(
        TMapFactory $TMapFactory,
        array       $resolvers
    )
    {
        $this->resolvers = $TMapFactory->createSharedObjectsMap([
            'type' => DocumentNodesResolverInterface::class,
            'array' => $resolvers
        ]);
    }

    public function resolve(): Generator
    {
        $paths = [];

        foreach ($this->resolvers as $resolver) {
            foreach ($resolver->resolve() as $documentNode) {
                /** @var \MateuszMesek\DocumentDataApi\Model\Data\DocumentNodeInterface $documentNode */
                $path = $documentNode->getPath();

                if (isset($paths[$path])) {
                    continue;
                }

                $paths[$path] = true;

                yield $documentNode;
            }
        }
    }
}
