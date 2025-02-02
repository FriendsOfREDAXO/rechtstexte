<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Model;

use eRecht24\RechtstexteSDK\Helper\Helper;

abstract class BaseModel
{
    /**
     * allowed properties
     *
     * @var array
     */
    protected $properties = [];

    /**
     * property values
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * BaseModel constructor.
     *
     * @param array|null $attributes
     */
    public function __construct(?array $attributes = null)
    {
        if ($attributes)
            $this->fill($attributes);
    }

    /**
     * Fill multiple attributes
     *
     * @param array $attributes
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * Get allowed properties for the model.
     *
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Provide all active properties and its values
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Provide single property value
     *
     * @param string $key
     * @return mixed|null
     */
    public function getAttribute(string $key)
    {
        if (array_key_exists($key, $this->attributes))
            return $this->attributes[$key];

        return null;
    }

    /**
     * Fill single property if allowed
     *
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        if ($this->isProperty($key))
            $this->attributes[$key] = $value;
    }

    /**
     * Check if property belongs to the model
     *
     * @param $key
     * @return bool
     */
    public function isProperty($key): bool
    {
        return in_array($key, $this->getProperties());
    }
}