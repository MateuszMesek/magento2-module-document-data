<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Command\GetDocumentNodeValue;

use MateuszMesek\DocumentDataApi\DocumentNodeValueResolverInterface;
use MateuszMesek\DocumentDataApi\InputInterface;

class CallbackResolver implements DocumentNodeValueResolverInterface
{
    private $callback;

    public function __construct(
        callable $callback
    )
    {
        $this->callback = $callback;
    }

    public function resolve(InputInterface $input)
    {
        return call_user_func($this->callback, $input);
    }
}
