<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Command;

use MateuszMesek\DocumentDataApi\Model\Command\GetDocumentNodeValueInterface;
use MateuszMesek\DocumentDataApi\Model\Data\DocumentNodeInterface;
use MateuszMesek\DocumentDataApi\Model\InputInterface;
use MateuszMesek\DocumentData\Model\Command\GetDocumentNodeValue\ResolverFactory;

class GetDocumentNodeValue implements GetDocumentNodeValueInterface
{
    public function __construct(
        private readonly ResolverFactory $resolverFactory
    )
    {
    }

    public function execute(DocumentNodeInterface $documentNode, InputInterface $input): mixed
    {
        return $this->resolverFactory->create($documentNode->getValueResolver())->resolve($input);
    }
}
