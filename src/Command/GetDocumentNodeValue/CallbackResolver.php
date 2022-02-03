<?php declare(strict_types=1);

namespace MateuszMesek\Document\Command\GetDocumentNodeValue;

use MateuszMesek\Document\Api\DocumentNodeValueResolverInterface;

class CallbackResolver implements DocumentNodeValueResolverInterface
{
    private $callback;

    public function __construct(
        callable $callback
    )
    {
        $this->callback = $callback;
    }

    public function resolve($input)
    {
        return call_user_func($this->callback, $input);
    }
}
