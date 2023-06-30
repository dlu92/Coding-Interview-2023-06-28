<?php

namespace App\Dto;

use Exception;

abstract class Dto
{

    /**
     * @param array $items
     */
    public function __construct($items = [])
    {
        foreach ($items as $key => $value) {
            $this->__set($key, $value);
        }   
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key): mixed
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        } else {
            throw new Exception("Cannot get value ({$key}) on dto");
        }
        
        return null;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set($key, $value): void
    {
        if(property_exists($this, $key)){
            $this->{$key} = $value;
        } else {
            throw new Exception("Cannot set value ({$key}) on dto");
        }
    }

    /**
     * @param string $key
     * @return void
     */
    public function offsetGet($key): mixed
    {
        return $this->__get($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        $this->__set($key, $value);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function __isset($key): bool
    {
        return property_exists($this, $key) && isset($this->{$key});
    }

}