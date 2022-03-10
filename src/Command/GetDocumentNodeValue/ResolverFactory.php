<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Command\GetDocumentNodeValue;

use Magento\Framework\ObjectManagerInterface;
use MateuszMesek\DocumentDataApi\DocumentNodeValueResolverInterface;

class ResolverFactory
{
    private ObjectManagerInterface $objectManager;

    public function __construct(
        ObjectManagerInterface $objectManager
    )
    {
        $this->objectManager = $objectManager;
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
