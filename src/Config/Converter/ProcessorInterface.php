<?php declare(strict_types=1);

namespace MateuszMesek\Document\Config\Converter;

interface ProcessorInterface
{
    public function process(\DOMNode $node): array;
}
