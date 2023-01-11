<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model;

use Magento\Framework\Config\DataInterface;
use MateuszMesek\DocumentDataApi\Model\Config\DocumentNamesInterface;

class Config implements DocumentNamesInterface
{
    public function __construct(
        private readonly DataInterface $data
    )
    {
    }

    public function getDocumentNames(): array
    {
        $documents = $this->data->get();

        return array_keys($documents);
    }

    public function getDocumentNodes(string $documentName): array
    {
        $nodes = $this->data->get("$documentName/nodes");

        if (null === $nodes) {
            $nodes = [];
        }

        return array_map(
            static function (array $node) use ($documentName) {
                $node['documentName'] = $documentName;

                return $node;
            },
            $nodes
        );
    }
}
