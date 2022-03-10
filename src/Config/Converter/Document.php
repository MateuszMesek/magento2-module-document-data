<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Config\Converter;

use DOMNode;
use MateuszMesek\Framework\Config\Converter\AttributeValueResolver;
use MateuszMesek\Framework\Config\Converter\ItemsResolver;
use MateuszMesek\Framework\Config\Converter\ProcessorInterface;

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
        $data = [
            'name' => $this->attributeValueResolver->resolve($node, 'name'),
            'nodes' => []
        ];

        $items = $this->itemsResolver->resolve($node, 'node');

        foreach ($items as $item) {
            $nodeData = $this->nodeProcessor->process($item);

            $data['nodes'][$nodeData['path']] = $nodeData;
        }

        return $data;
    }
}
