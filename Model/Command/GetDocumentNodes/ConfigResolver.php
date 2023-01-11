<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Command\GetDocumentNodes;

use Generator;
use MateuszMesek\DocumentData\Model\Data\DocumentNodeFactory;
use MateuszMesek\DocumentDataApi\Model\DocumentNodesResolverInterface;
use MateuszMesek\DocumentData\Model\Config;

class ConfigResolver implements DocumentNodesResolverInterface
{
    public function __construct(
        private readonly DocumentNodeFactory $documentNodeFactory,
        private readonly Config $config,
        private readonly string $documentName
    )
    {
    }

    public function resolve(): Generator
    {
        $nodes = $this->config->getDocumentNodes($this->documentName);

        foreach ($nodes as $node) {
            yield $this->documentNodeFactory->create($node);
        }
    }
}
