<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Data;

use MateuszMesek\DocumentDataApi\Data\DocumentNodeInterface;

class DocumentNode implements DocumentNodeInterface
{
    private string $document;
    private string $path;
    /**
     * @var mixed
     */
    private $valueResolver;

    public function __construct(
        string $document,
        string $path,
        $valueResolver
    )
    {
        $this->document = $document;
        $this->path = $path;
        $this->valueResolver = $valueResolver;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getValueResolver()
    {
        return $this->valueResolver;
    }
}
