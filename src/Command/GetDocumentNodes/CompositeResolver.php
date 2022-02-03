<?php declare(strict_types=1);

namespace MateuszMesek\Document\Command\GetDocumentNodes;

use Generator;
use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;
use MateuszMesek\Document\Api\DocumentNodesResolverInterface;

class CompositeResolver implements DocumentNodesResolverInterface
{
    /**
     * @var TMap|DocumentNodesResolverInterface[]
     */
    private TMap $resolvers;

    public function __construct(
        TMapFactory $TMapFactory,
        array $resolvers
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
            foreach ($resolver->resolve() as $node) {
                $path = $node['path'];

                if (isset($paths[$path])) {
                    continue;
                }

                $paths[$path] = true;

                yield $node;
            }
        }
    }
}
