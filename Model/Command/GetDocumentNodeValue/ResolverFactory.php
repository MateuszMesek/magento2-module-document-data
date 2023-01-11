<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Command\GetDocumentNodeValue;

use Magento\Framework\ObjectManagerInterface;
use MateuszMesek\DocumentDataApi\Model\DocumentNodeValueResolverInterface;

class ResolverFactory
{
    public function __construct(
        private readonly ObjectManagerInterface $objectManager
    )
    {
    }

    public function create($resolver): DocumentNodeValueResolverInterface
    {
        if (is_string($resolver)) {
            return $this->objectManager->get($resolver);
        }

        return $this->objectManager->create(
            CallbackResolver::class,
            [
                'callback' => $resolver
            ]
        );
    }
}
