<?php declare(strict_types=1);

namespace MateuszMesek\Document\Config;

use DOMNode;
use Magento\Framework\Config\ConverterInterface;
use MateuszMesek\Document\Config\Converter\ItemsResolver;
use MateuszMesek\Document\Config\Converter\ProcessorInterface;

class Converter implements ConverterInterface
{
    private ItemsResolver $itemsResolver;
    private ProcessorInterface $documentProcessor;

    public function __construct(
        ItemsResolver $itemsResolver,
        ProcessorInterface $documentProcessor
    )
    {
        $this->itemsResolver = $itemsResolver;
        $this->documentProcessor = $documentProcessor;
    }

    public function convert($source): array
    {
        return array_map(
            function (DOMNode $item) {
                return $this->documentProcessor->process($item);
            },
            $this->itemsResolver->resolve($source, 'document')
        );
    }
}
