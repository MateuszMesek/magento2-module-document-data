<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Command\GetDocumentNodes\ReflectionResolver;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Reflection\MethodsMap;
use Magento\Framework\Reflection\MethodsMap\Proxy;

class LimitedMethodsMap extends Proxy
{
    private string $methodName;

    public function __construct(
        string $methodName,
        ObjectManagerInterface $objectManager,
        $instanceName = MethodsMap::class
    )
    {
        $this->methodName = $methodName;

        parent::__construct(
            $objectManager,
            $instanceName,
            true
        );
    }

    public function getMethodsMap($interfaceName)
    {
        $map = parent::getMethodsMap($interfaceName);

        if (!isset($map[$this->methodName])) {
            return [];
        }

        return [
            $this->methodName => $map[$this->methodName]
        ];
    }
}
