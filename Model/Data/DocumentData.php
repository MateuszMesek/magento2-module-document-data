<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Model\Data;

use Magento\Framework\Stdlib\ArrayManager;
use MateuszMesek\DocumentDataApi\Model\Data\DocumentDataInterface;

class DocumentData implements DocumentDataInterface
{
    public function __construct(
        private readonly ArrayManager $arrayManager,
        private array                 $data = []
    )
    {
    }

    public function set(string $path, mixed $value): void
    {
        $this->data = $this->arrayManager->set(
            $path,
            $this->data,
            $value
        );
    }

    public function get(string $path): mixed
    {
        return $this->prepareValue(
            $this->arrayManager->get(
                $path,
                $this->data
            )
        );
    }

    public function getData(): array
    {
        return $this->prepareValue(
            $this->data
        );
    }

    private function prepareValue(mixed $input): mixed
    {
        if (is_callable($input) && !is_string($input)) {
            return $input();
        }

        if (is_array($input)) {
            foreach ($input as $key => $value) {
                $input[$key] = $this->prepareValue($value);
            }
        }

        return $input;
    }
}
