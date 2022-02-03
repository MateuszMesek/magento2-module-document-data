<?php declare(strict_types=1);

namespace MateuszMesek\Document\Command;

use Magento\Framework\Stdlib\ArrayManager;
use MateuszMesek\Document\Api\Command\GetDocumentDataInterface;
use MateuszMesek\Document\Api\Command\GetDocumentNodesInterface;
use MateuszMesek\Document\Api\Command\GetDocumentNodeValueInterface;
use MateuszMesek\Document\Api\InputInterface;
use MateuszMesek\Document\Data\DocumentNodeFactory;

class GetDocumentData implements GetDocumentDataInterface
{
    private GetDocumentNodesInterface $getDocumentNodes;
    private GetDocumentNodeValueInterface $getDocumentNodeValue;
    private DocumentNodeFactory $documentNodeFactory;
    private ArrayManager $arrayManager;

    public function __construct(
        GetDocumentNodesInterface $getDocumentNodes,
        GetDocumentNodeValueInterface $getDocumentNodeValue,
        DocumentNodeFactory $documentNodeFactory,
        ArrayManager $arrayManager
    )
    {
        $this->getDocumentNodes = $getDocumentNodes;
        $this->getDocumentNodeValue = $getDocumentNodeValue;
        $this->documentNodeFactory = $documentNodeFactory;
        $this->arrayManager = $arrayManager;
    }

    public function execute(string $document, InputInterface $input): array
    {
        $data = [];
        $nodes = $this->getDocumentNodes->execute($document);

        foreach ($nodes as $node) {
            $documentNode = $this->documentNodeFactory->create(array_merge(
                $node,
                [
                    'document' => $document
                ]
            ));

            $data = $this->arrayManager->set(
                $node['path'],
                $data,
                $this->getDocumentNodeValue->execute($documentNode, $input)
            );
        }

        return $data;
    }
}
