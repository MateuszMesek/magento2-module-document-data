<?php declare(strict_types=1);

namespace MateuszMesek\Document\Data;

use MateuszMesek\Document\Api\Data\DocumentNodeInterface;

class DocumentNode implements DocumentNodeInterface
{
    private string $document;
    private string $path;
    /**
     * @var mixed
     */
    private $resolver;

    public function __construct(
        string $document,
        string $path,
        $resolver
    )
    {
        $this->document = $document;
        $this->path = $path;
        $this->resolver = $resolver;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getResolver()
    {
        return $this->resolver;
    }
}
