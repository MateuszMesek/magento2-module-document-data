<?php declare(strict_types=1);

namespace MateuszMesek\Document;

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

    public function getDocumentNodes(string $document): array
    {
        $nodes = $this->data->get($document);

        if (null === $nodes) {
            $nodes = [];
        }

        return $nodes;
    }
}
