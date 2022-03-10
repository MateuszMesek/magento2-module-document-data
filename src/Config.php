<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData;

use Magento\Framework\Config\DataInterface;

class Config
{
    private DataInterface $data;

    public function __construct(
        DataInterface $data
    )
    {
        $this->data = $data;
    }

    public function getDocumentNames(): array
    {
        $documents = $this->data->get();

        return array_keys($documents);
    }

    public function getDocumentNodes(string $document): array
    {
        $nodes = $this->data->get("$document/nodes");

        if (null === $nodes) {
            $nodes = [];
        }

        return $nodes;
    }
}
