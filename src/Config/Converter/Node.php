<?php declare(strict_types=1);

namespace MateuszMesek\Document\Config\Converter;

use DOMNode;

class Node implements ProcessorInterface
{
    private AttributeValueResolver $attributeValueResolver;
    private NodeResolverNameResolver$nodeResolverNameResolver;

    public function __construct(
        AttributeValueResolver $attributeValueResolver,
        NodeResolverNameResolver $nodeResolverNameResolver
    )
    {
        $this->attributeValueResolver = $attributeValueResolver;
        $this->nodeResolverNameResolver = $nodeResolverNameResolver;
    }

    public function process(DOMNode $node): array
    {
        return [
            'path' => $this->attributeValueResolver->resolve($node, 'path'),
            'resolver' => $this->nodeResolverNameResolver->resolve($node)
        ];
    }
}
