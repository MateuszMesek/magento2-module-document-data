<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Command\GetDocumentNodes;

use Generator;
use MateuszMesek\DocumentDataApi\DocumentNodesResolverInterface;
use MateuszMesek\DocumentData\Config;

class ConfigResolver implements DocumentNodesResolverInterface
{
    private Config $config;
    private string $documentName;

    public function __construct(
        Config $config,
        string $documentName
    )
    {
        $this->config = $config;
        $this->documentName = $documentName;
    }

    public function resolve(): Generator
    {
        $nodes = $this->config->getDocumentNodes($this->documentName);

        foreach ($nodes as $node) {
            yield $node;
        }
    }
}
