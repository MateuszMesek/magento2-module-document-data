<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Command;

use MateuszMesek\DocumentDataApi\Command\GetDocumentDataInterface;
use MateuszMesek\DocumentDataApi\Command\GetDocumentNodesInterface;
use MateuszMesek\DocumentDataApi\Command\GetDocumentNodeValueInterface;
use MateuszMesek\DocumentDataApi\Data\DocumentDataInterface;
use MateuszMesek\DocumentDataApi\InputInterface;
use MateuszMesek\DocumentData\Data\DocumentDataFactory;
use MateuszMesek\DocumentData\Data\DocumentNodeFactory;

class GetDocumentData implements GetDocumentDataInterface
{
    private GetDocumentNodesInterface $getDocumentNodes;
    private GetDocumentNodeValueInterface $getDocumentNodeValue;
    private DocumentDataFactory $documentDataFactory;
    private DocumentNodeFactory $documentNodeFactory;

    public function __construct(
        GetDocumentNodesInterface $getDocumentNodes,
        GetDocumentNodeValueInterface $getDocumentNodeValue,
        DocumentDataFactory $documentDataFactory,
        DocumentNodeFactory $documentNodeFactory
    )
    {
        $this->getDocumentNodes = $getDocumentNodes;
        $this->getDocumentNodeValue = $getDocumentNodeValue;
        $this->documentDataFactory = $documentDataFactory;
        $this->documentNodeFactory = $documentNodeFactory;
    }

    public function execute(string $documentName, InputInterface $input): ?DocumentDataInterface
    {
        if (!$input->getId()) {
            return null;
        }

        $documentData = $this->documentDataFactory->create();
        $documentData->set('id', $input->getId());

        $nodes = $this->getDocumentNodes->execute($documentName);

        foreach ($nodes as $node) {
            $documentNode = $this->documentNodeFactory->create(array_merge(
                $node,
                [
                    'document' => $documentName
                ]
            ));

            $documentData->set($node['path'], function() use ($documentNode, $input) {
                return $this->getDocumentNodeValue->execute($documentNode, $input);
            });
        }

        return $documentData;
    }
}
