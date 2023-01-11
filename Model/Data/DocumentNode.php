<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Data;

use MateuszMesek\DocumentDataApi\Model\Data\DocumentNodeInterface;

class DocumentNode implements DocumentNodeInterface
{
    public function __construct(
        private readonly string $documentName,
        private readonly string $path,
        private readonly mixed  $valueResolver
    )
    {
    }

    public function getDocumentName(): string
    {
        return $this->documentName;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getValueResolver(): mixed
    {
        return $this->valueResolver;
    }
}
