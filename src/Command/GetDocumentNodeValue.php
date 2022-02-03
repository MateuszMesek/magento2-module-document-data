<?php declare(strict_types=1);

namespace MateuszMesek\Document\Command;

use MateuszMesek\Document\Api\Command\GetDocumentNodeValueInterface;
use MateuszMesek\Document\Api\Data\DocumentNodeInterface;
use MateuszMesek\Document\Api\InputInterface;
use MateuszMesek\Document\Command\GetDocumentNodeValue\ResolverFactory;

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
        $resolver = $this->resolverFactory->create($documentNode->getResolver());

        return $resolver->resolve($input);
    }
}
