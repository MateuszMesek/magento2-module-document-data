<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Command\GetDocumentNodeValue;

use MateuszMesek\DocumentDataApi\Model\DocumentNodeValueResolverInterface;
use MateuszMesek\DocumentDataApi\Model\InputInterface;

class CallbackResolver implements DocumentNodeValueResolverInterface
{
    private $callback;

    public function __construct(
        callable $callback
    )
    {
        $this->callback = $callback;
    }

    public function resolve(InputInterface $input): mixed
    {
        return call_user_func($this->callback, $input);
    }
}
