<?php declare(strict_types=1);

namespace MateuszMesek\DocumentData\Data;

use Magento\Framework\Stdlib\ArrayManager;
use MateuszMesek\DocumentDataApi\Data\DocumentDataInterface;

class DocumentData implements DocumentDataInterface
{
    private ArrayManager $arrayManager;
    private array $data;

    public function __construct(
        ArrayManager $arrayManager,
        array $data = []
    )
    {
        $this->arrayManager = $arrayManager;
        $this->data = $data;
    }

    public function set(string $path, $value): void
    {
        $this->data = $this->arrayManager->set(
            $path,
            $this->data,
            $value
        );
    }

    public function get(string $path)
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

    private function prepareValue($input)
    {
        if (is_callable($input)) {
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
