<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Config;

use Magento\Framework\Config\ConverterInterface;
use MateuszMesek\Framework\Config\Converter\ItemsResolver;
use MateuszMesek\Framework\Config\Converter\ProcessorInterface;

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
        $data = [];

        $items = $this->itemsResolver->resolve($source, 'document');

        foreach ($items as $item) {
            $documentData = $this->documentProcessor->process($item);

            $data[$documentData['name']] = $documentData;
        }

        return $data;
    }
}
