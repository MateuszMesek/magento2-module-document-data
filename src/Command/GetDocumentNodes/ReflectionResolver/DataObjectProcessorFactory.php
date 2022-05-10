<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Command\GetDocumentNodes\ReflectionResolver;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Reflection\DataObjectProcessor;

class DataObjectProcessorFactory
{
    private ObjectManagerInterface $objectManager;

    public function __construct(
        ObjectManagerInterface $objectManager
    )
    {
        $this->objectManager = $objectManager;
    }

    public function create(string $methodName): DataObjectProcessor
    {
        return $this->objectManager->create(
            DataObjectProcessor::class,
            [
                'methodsMapProcessor' => $this->objectManager->create(
                    LimitedMethodsMap::class,
                    [
                        'methodName' => $methodName
                    ]
                )
            ]
        );
    }
}
