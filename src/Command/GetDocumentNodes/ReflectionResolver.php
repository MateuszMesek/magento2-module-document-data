<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Command\GetDocumentNodes;

use Generator;
use Magento\Framework\Reflection\FieldNamer;
use Magento\Framework\Reflection\MethodsMap;
use MateuszMesek\DocumentDataApi\DocumentNodesResolverInterface;
use MateuszMesek\DocumentDataApi\InputInterface;

class ReflectionResolver implements DocumentNodesResolverInterface
{
    private MethodsMap $methodsMap;
    private FieldNamer $fieldNamer;
    private string $type;
    private array $ignoreKeys;

    public function __construct(
        MethodsMap $methodsMap,
        FieldNamer $fieldNamer,
        string $type,
        array $ignoreKeys = []
    )
    {
        $this->methodsMap = $methodsMap;
        $this->fieldNamer = $fieldNamer;
        $this->type = $type;
        $this->ignoreKeys = array_keys(
            array_filter(
                $ignoreKeys
            )
        );
    }

    public function resolve(): Generator
    {
        $methods = $this->methodsMap->getMethodsMap($this->type);

        foreach (array_keys($methods) as $methodName) {
            if (!$this->methodsMap->isMethodValidForDataField($this->type, $methodName)) {
                continue;
            }

            $key = $this->fieldNamer->getFieldNameForMethodName($methodName);

            if (in_array($key, $this->ignoreKeys, true)) {
                continue;
            }

            yield [
                'path' => $key,
                'valueResolver' => function (InputInterface $input) use ($methodName) {
                    $instance = $this->getInstance($input);

                    if (!$instance) {
                        return null;
                    }

                    return $instance->{$methodName}();
                },
            ];
        }
    }

    private function getInstance(InputInterface $input)
    {
        $methods = $this->methodsMap->getMethodsMap(get_class($input));

        foreach ($methods as $methodName => $method) {
            if (ltrim($method['type'], '\\') !== $this->type) {
                continue;
            }

            return $input->{$methodName}();
        }

        return null;
    }
}
