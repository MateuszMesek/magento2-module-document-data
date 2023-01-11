<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Command\GetDocumentNodes;

use Generator;
use Magento\Framework\Reflection\FieldNamer;
use Magento\Framework\Reflection\MethodsMap;
use MateuszMesek\DocumentData\Model\Command\GetDocumentNodes\ReflectionResolver\DataObjectProcessorFactory;
use MateuszMesek\DocumentData\Model\Data\DocumentNodeFactory;
use MateuszMesek\DocumentDataApi\Model\DocumentNodesResolverInterface;
use MateuszMesek\DocumentDataApi\Model\InputInterface;

class ReflectionResolver implements DocumentNodesResolverInterface
{
    private array $ignoreKeys;

    public function __construct(
        private readonly string                     $documentName,
        private readonly DocumentNodeFactory        $documentNodeFactory,
        private readonly MethodsMap                 $methodsMap,
        private readonly FieldNamer                 $fieldNamer,
        private readonly DataObjectProcessorFactory $dataObjectProcessorFactory,
        private readonly string                     $type,
        array                                       $ignoreKeys = []
    )
    {
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

            yield $this->documentNodeFactory->create([
                'documentName' => $this->documentName,
                'path' => $key,
                'valueResolver' => function (InputInterface $input) use ($methodName) {
                    $instance = $this->getInstance($input);

                    if (!$instance) {
                        return null;
                    }

                    return $this->getValue($instance, $methodName);
                }
            ]);
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

    private function getValue($instance, string $methodName)
    {
        $dataObjectProcessor = $this->dataObjectProcessorFactory->create($this->type, $methodName);

        $data = $dataObjectProcessor->buildOutputDataArray($instance, $this->type);
        $key = $this->fieldNamer->getFieldNameForMethodName($methodName);

        return $data[$key] ?? null;
    }
}
