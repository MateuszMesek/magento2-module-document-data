<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Command;

use Magento\Framework\Stdlib\ArrayManager;
use MateuszMesek\DocumentDataApi\Command\GetDocumentDataInterface;
use MateuszMesek\DocumentDataApi\Command\GetDocumentNodesInterface;
use MateuszMesek\DocumentDataApi\Command\GetDocumentNodeValueInterface;
use MateuszMesek\DocumentDataApi\InputInterface;
use MateuszMesek\DocumentData\Data\DocumentNodeFactory;

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

    public function execute(string $documentName, InputInterface $input): array
    {
        $data = [
            'id' => $input->getId()
        ];
        $nodes = $this->getDocumentNodes->execute($documentName);

        foreach ($nodes as $node) {
            $documentNode = $this->documentNodeFactory->create(array_merge(
                $node,
                [
                    'document' => $documentName
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
