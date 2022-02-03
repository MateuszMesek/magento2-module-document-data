<?php declare(strict_types=1);

namespace MateuszMesek\Document\Config\Converter;

use DOMNode;
use const XML_ELEMENT_NODE;

class ChildrenResolver
{
    /**
     * @param DOMNode $node
     * @return DOMNode[]
     */
    public function resolve(DOMNode $node): array
    {
        return array_filter(
            $node->childNodes,
            static function (DOMNode $item) {
                return $item->nodeType === XML_ELEMENT_NODE;
            }
        );
    }
}
