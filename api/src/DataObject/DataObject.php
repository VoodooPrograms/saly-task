<?php

namespace App\DataObject;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionType;

abstract class DataObject
{
    public function __construct(array $parameters) {

        $class = new ReflectionClass(static::class);

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty){
            $property = $reflectionProperty->getName();
            if ($reflectionProperty->getType() != null && !$this->isBuiltin($reflectionProperty->getType())) {
                $ref = new ReflectionClass($reflectionProperty->getType()->getName());
                if ($ref->isSubclassOf(DataObject::class)) {
                    $this->{$property} = $ref->newInstance($parameters[$property]);
                } else if(isset($parameters[$property])) {
                    $this->{$property} = $parameters[$property];
                }
            }
            else if (isset($parameters[$property])) {
                $this->{$property} = $parameters[$property];
            }
        }

    }

    public function toArray(): array
    {
        return (array)$this;
    }

    /**
     * In PHP8.0 ReflectionType can be either ReflectionNamedType or ReflectionUnionType.
     * So we will need to check specific instance first to check if type is builtin.
     *
     * @param ReflectionType|null $type
     * @return bool
     */
    private function isBuiltin(?ReflectionType $type): bool
    {
        return $type instanceof ReflectionNamedType && $type->isBuiltin();
    }
}