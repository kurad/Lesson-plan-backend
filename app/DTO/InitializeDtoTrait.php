<?php

declare(strict_types=1);

namespace App\DTO;

use Exception;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionUnionType;

trait InitializeDtoTrait
{
    /**
     * @throws Exception
     */
    public function __construct(array $data)
    {
        $reflection = new ReflectionClass(static::class);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();

            $isPublic = $property->isPublic();
            $type = $property->getType();
            $isStatic = $property->isStatic();

            $value = $data[$propertyName] ?? null;

            $propertyTypeName = $this->getPropertyTypeName($type, $value, $propertyName);

            $typeName = self::translateTypeName($propertyTypeName, $value);
            $valueTypeName = self::translateTypeName(gettype($value), $value);

            if (!$isPublic) {
                continue;
            }

            if ($isStatic) {
                continue;
            }

            if ($type->allowsNull() && is_null($value)) {
                $this->$propertyName = $value;
                continue;
            }

            if (!$type->allowsNull() && is_null($value)) {
                throw new Exception("property $propertyName of type $typeName can't be null");
            }

            // check if the values passed to this property values is array and  it's type in DTO is a class

            if ($typeName !== $valueTypeName) {
                throw new Exception("property $propertyName should be of type $typeName");
            }

            $this->$propertyName = $value;
        }
    }

    private function getPropertyTypeName(ReflectionNamedType|ReflectionUnionType $type, mixed $value, string $propertyName): string
    {
        if ($type instanceof ReflectionNamedType) {
            return $type->getName();
        }

        $unionTypes = $type->getTypes();

        $allowedTypes = array_map(function (ReflectionNamedType $tp) {
            return $tp->getName();
        }, $unionTypes);

        $valueTypeName = self::translateTypeName(gettype($value), $value);

        if (!in_array($valueTypeName, $allowedTypes)) {
            throw new Exception("property $propertyName should be of one of these types " . implode(",", $allowedTypes) . " but $valueTypeName was given");
        }

        return $valueTypeName;
    }

    private static function translateTypeName(string $type, $value): string
    {
        return match ($type) {
            "boolean" => "bool",
            "double" => "float",
            "integer" => "int",
            "NULL", "null" => "null",
            "object" => is_object($value) ? get_class($value) : "object",
            default => $type
        };
    }
}