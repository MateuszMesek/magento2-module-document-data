<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Command;

use MateuszMesek\DocumentDataApi\Model\Command\GetDocumentDataInterface;
use MateuszMesek\DocumentDataApi\Model\Command\GetDocumentNodesInterface;
use MateuszMesek\DocumentDataApi\Model\Command\GetDocumentNodeValueInterface;
use MateuszMesek\DocumentDataApi\Model\Data\DocumentDataInterface;
use MateuszMesek\DocumentDataApi\Model\InputInterface;
use MateuszMesek\DocumentData\Model\Data\DocumentDataFactory;
use MateuszMesek\DocumentData\Model\Data\DocumentNodeFactory;

class GetDocumentData implements GetDocumentDataInterface
{
    public function __construct(
        private readonly GetDocumentNodesInterface     $getDocumentNodes,
        private readonly GetDocumentNodeValueInterface $getDocumentNodeValue,
        private readonly DocumentDataFactory           $documentDataFactory,
        private readonly DocumentNodeFactory           $documentNodeFactory
    )
    {
    }

    public function execute(string $documentName, InputInterface $input): ?DocumentDataInterface
    {
        if (!$input->getId()) {
            return null;
        }

        $documentData = $this->documentDataFactory->create();

        $documentNodes = $this->getDocumentNodes->execute($documentName);

        foreach ($documentNodes as $documentNode) {
            if (is_array($documentNode)) {
                $documentNode = $this->documentNodeFactory->create(array_merge(
                    $documentNode,
                    [
                        'documentName' => $documentName
                    ]
                ));
            }

            $documentData->set($documentNode->getPath(), function () use ($documentNode, $input) {
                return $this->getDocumentNodeValue->execute($documentNode, $input);
            });
        }

        return $documentData;
    }
}
