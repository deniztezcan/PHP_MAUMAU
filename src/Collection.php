<?php

namespace DenizTezcan\MauMau;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Collection implements IteratorAggregate, ArrayAccess, Countable
{
	/**
     * Class properties
     */
    /**
     * Collection of data attributes
     *
     * @type array
     */
    protected $attributes = [];

    /**
     * Methods
     */
    /**
     * Constructor
     *
     * @param array $attributes The data attributes of this collection
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Returns all of the attributes in the collection
     *
     * If an optional mask array is passed, this only
     * returns the keys that match the mask
     *
     * @return array
     */
    public function all(): array
    {
    	return $this->attributes;
    }

    /**
     * Return an attribute of the collection
     *
     * Return a default value if the key doesn't exist
     *
     * @param string $key           The name of the parameter to return
     * @param mixed  $default_val   The default value of the parameter if it contains no value
     * @return mixed
     */
    public function get($key, $default_val = null)
    {
        if ($this->exists($key)) {
            return $this->attributes[$key];
        }

        return $default_val;
    }

    /**
     * Set an attribute of the collection
     *
     * @param string $key   The name of the parameter to set
     * @param mixed  $value The value of the parameter to set
     * @return Collection
     */
    public function set($key, $value): object
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * See if an attribute exists in the collection
     *
     * @param string $key   The name of the parameter
     * @return boolean
     */
    public function exists($key): bool
    {
        // Don't use "isset", since it returns false for null values
        return array_key_exists($key, $this->attributes);
    }

    /**
     * Remove an attribute from the collection
     *
     * @param string $key   The name of the parameter
     * @return void
     */
    public function remove($key): void
    {
        unset($this->attributes[$key]);
        $this->attributes = array_values($this->attributes);
    }

    /**
     * Clear the collection's contents
     *
     * @return Collection
     */
    public function clear(): object
    {
    	$this->attributes = [];
        return $this;
    }

    /*
     * Interface required method implementations
     */
    
    /**
     * Get the aggregate iterator
     *
     * IteratorAggregate interface required method
     *
     * @see \IteratorAggregate::getIterator()
     * @return ArrayIterator
     */
    public function getIterator(): object
    {
        return new ArrayIterator($this->attributes);
    }
    
    /**
     * Get an attribute via array syntax
     *
     * Allows the access of attributes of this instance while treating it like an array
     *
     * @see \ArrayAccess::offsetGet()
     * @see get()
     * @param string $key   The name of the parameter to return
     * @return mixed
     */
    public function offsetGet($key): mixed
    {
        return $this->get($key);
    }
    
    /**
     * Set an attribute via array syntax
     *
     * Allows the access of attributes of this instance while treating it like an array
     *
     * @see \ArrayAccess::offsetSet()
     * @see set()
     * @param string $key   The name of the parameter to set
     * @param mixed  $value The value of the parameter to set
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        $this->set($key, $value);
    }
    
    /**
     * Check existence an attribute via array syntax
     *
     * Allows the access of attributes of this instance while treating it like an array
     *
     * @see \ArrayAccess::offsetExists()
     * @see exists()
     * @param string $key   The name of the parameter
     * @return boolean
     */
    public function offsetExists($key): bool
    {
        return $this->exists($key);
    }
    
    /**
     * Remove an attribute via array syntax
     *
     * Allows the access of attributes of this instance while treating it like an array
     *
     * @see \ArrayAccess::offsetUnset()
     * @see remove()
     * @param string $key   The name of the parameter
     * @return void
     */
    public function offsetUnset($key): void
    {
        $this->remove($key);
    }
    
    /**
     * Count the attributes via a simple "count" call
     *
     * Allows the use of the "count" function (or any internal counters)
     * to simply count the number of attributes in the collection.
     *
     * @see \Countable::count()
     * @return int
     */
    public function count(): int
    {
        return count($this->attributes);
    }

    /**
     * Checks if attributes are set
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return (bool) $this->count();
    }
}