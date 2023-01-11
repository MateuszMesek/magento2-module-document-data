<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Command\GetDocumentNodes\ReflectionResolver;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Reflection\MethodsMap;
use Magento\Framework\Reflection\MethodsMap\Proxy;

class LimitedMethodsMap extends Proxy
{
    public function __construct(
        private readonly string $type,
        private readonly string $methodName,
        ObjectManagerInterface  $objectManager,
                                $instanceName = MethodsMap::class
    )
    {
        parent::__construct(
            $objectManager,
            $instanceName,
            true
        );
    }

    public function getMethodsMap($interfaceName)
    {
        $map = parent::getMethodsMap($interfaceName);

        if ($interfaceName !== $this->type) {
            return $map;
        }

        if (!isset($map[$this->methodName])) {
            return [];
        }

        return [
            $this->methodName => $map[$this->methodName]
        ];
    }
}
