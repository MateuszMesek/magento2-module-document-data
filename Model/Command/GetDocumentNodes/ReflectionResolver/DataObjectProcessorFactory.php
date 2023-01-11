<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Command\GetDocumentNodes\ReflectionResolver;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Reflection\DataObjectProcessor;

class DataObjectProcessorFactory
{
    public function __construct(
        private readonly ObjectManagerInterface $objectManager
    )
    {
    }

    public function create(string $type, string $methodName): DataObjectProcessor
    {
        return $this->objectManager->create(
            DataObjectProcessor::class,
            [
                'methodsMapProcessor' => $this->objectManager->create(
                    LimitedMethodsMap::class,
                    [
                        'type' => $type,
                        'methodName' => $methodName
                    ]
                )
            ]
        );
    }
}
