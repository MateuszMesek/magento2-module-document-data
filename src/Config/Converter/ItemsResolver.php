<?php declare(strict_types=1);

namespace MateuszMesek\Document\Config\Converter;

use DOMDocument;
use DOMNode;
use DOMNodeList;
use const XML_ELEMENT_NODE;

class ItemsResolver
{
    private ChildrenResolver $childrenResolver;

    public function __construct(
        ChildrenResolver $childrenResolver
    )
    {
        $this->childrenResolver = $childrenResolver;
    }

    public function resolve(DOMNode $node, string $nodeName): array
    {
        if ($node instanceof DOMDocument) {
            $items = (array)$node->getElementsByTagName($nodeName);
        } else {
            $items = $this->childrenResolver->resolve($node);
        }

        return array_filter(
            $items,
            static function (DOMNode $item) use ($nodeName) {
                return $item->nodeName === $nodeName;
            }
        );
    }
}
