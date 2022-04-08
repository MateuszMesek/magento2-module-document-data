<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Config\Converter;

use DOMNode;
use MateuszMesek\Framework\Config\Converter\AttributeValueResolver;
use MateuszMesek\Framework\Config\Converter\ChildrenResolver;
use MateuszMesek\Framework\Config\Converter\ProcessorInterface;

class Node implements ProcessorInterface
{
    private const NODES = [
        'valueResolver'
    ];

    private AttributeValueResolver $attributeValueResolver;
    private ChildrenResolver $childrenResolver;

    public function __construct(
        AttributeValueResolver $attributeValueResolver,
        ChildrenResolver $childrenResolver
    )
    {
        $this->attributeValueResolver = $attributeValueResolver;
        $this->childrenResolver = $childrenResolver;
    }

    public function process(DOMNode $node): array
    {
        $data = [
            'path' => $this->attributeValueResolver->resolve($node, 'path')
        ];

        foreach ($this->childrenResolver->resolve($node) as $child) {
            if (!in_array($child->nodeName, self::NODES, true)) {
                continue;
            }

            $data[$child->nodeName] = $this->attributeValueResolver->resolve($child, 'name');
        }

        return $data;
    }
}
