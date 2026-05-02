<?php

namespace App\Services\FieldTypes;

use App\Services\FieldTypes\Contracts\FieldTypeInterface;

class FieldTypeRegistry
{
    private array $types = [];

    public function register(FieldTypeInterface $type): void
    {
        $this->types[$type->getType()] = $type;
    }

    public function get(string $type): FieldTypeInterface
    {
        if (!$this->has($type)) {
            throw new \InvalidArgumentException("Field type '{$type}' is not supported.");
        }

        return $this->types[$type];
    }

    public function has(string $type): bool
    {
        return isset($this->types[$type]);
    }

    public function all(): array
    {
        return array_keys($this->types);
    }
}
