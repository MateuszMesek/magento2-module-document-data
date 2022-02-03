<?php declare(strict_types=1);

namespace MateuszMesek\Document\Config\Converter;

use DOMNode;

class Document implements ProcessorInterface
{
    private AttributeValueResolver $attributeValueResolver;
    private ItemsResolver $itemsResolver;
    private ProcessorInterface $nodeProcessor;

    public function __construct(
        AttributeValueResolver $attributeValueResolver,
        ItemsResolver $itemsResolver,
        ProcessorInterface $nodeProcessor
    )
    {
        $this->attributeValueResolver = $attributeValueResolver;
        $this->itemsResolver = $itemsResolver;
        $this->nodeProcessor = $nodeProcessor;
    }

    public function process(DOMNode $node): array
    {
        return [
            'name' => $this->attributeValueResolver->resolve($node, 'name'),
            'nodes' => array_map(
                function (DOMNode $node) {
                    return $this->nodeProcessor->process($node);
                },
                $this->itemsResolver->resolve($node, 'node')
            )
        ];
    }
}
