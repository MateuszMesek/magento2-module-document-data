<?php declare(strict_types=1);

namespace MateuszMesek\Document\Config\Converter;

use DOMNode;

class NodeResolverNameResolver
{
    private ChildrenResolver $childrenResolver;

    public function __construct(
        ChildrenResolver $childrenResolver
    )
    {
        $this->childrenResolver = $childrenResolver;
    }

    public function resolve(DOMNode $node): string
    {
        foreach ($this->childrenResolver->resolve($node) as $item) {
            if ($item->nodeType !== 'resolver') {
                continue;
            }

            return (string)$item->nodeValue;
        }
    }
}
