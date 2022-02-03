<?php declare(strict_types=1);

namespace MateuszMesek\Document\Config\Converter;

use DOMNode;

class AttributeValueResolver
{
    public function resolve(DOMNode $node, string $attributeName, $default = null)
    {
        $attributeNode = $node->attributes->getNamedItem($attributeName);

        return $attributeNode->nodeValue ?? $default;
    }
}
