<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Command;

use MateuszMesek\DocumentDataApi\Command\GetDocumentNodeValueInterface;
use MateuszMesek\DocumentDataApi\Data\DocumentNodeInterface;
use MateuszMesek\DocumentDataApi\InputInterface;
use MateuszMesek\DocumentData\Command\GetDocumentNodeValue\ResolverFactory;

class GetDocumentNodeValue implements GetDocumentNodeValueInterface
{
    private ResolverFactory $resolverFactory;

    public function __construct(
        ResolverFactory $resolverFactory
    )
    {
        $this->resolverFactory = $resolverFactory;
    }

    public function execute(DocumentNodeInterface $documentNode, InputInterface $input)
    {
        return $this->resolverFactory->create($documentNode->getValueResolver())->resolve($input);
    }
}
