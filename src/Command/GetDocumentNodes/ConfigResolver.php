<?php declare(strict_types=1);

namespace MateuszMesek\Document\Command\GetDocumentNodes;

use Generator;
use MateuszMesek\Document\Api\DocumentNodesResolverInterface;
use MateuszMesek\Document\Config;

class ConfigResolver implements DocumentNodesResolverInterface
{
    private Config $config;
    private string $document;

    public function __construct(
        Config $config,
        string $document
    )
    {
        $this->config = $config;
        $this->document = $document;
    }

    public function resolve(): Generator
    {
        $nodes = $this->config->getDocumentNodes($this->document);

        foreach ($nodes as $node) {
            yield $node;
        }
    }
}
