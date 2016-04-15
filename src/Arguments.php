<?php

namespace CLI;

class Arguments
{

    /**
     * @var array
     */
    private $arguments;

    /**
     * @var array
     */
    private $flags;

    public function __construct($arguments)
    {
        $this->arguments = array();

        if(isset($arguments['__global__']))
        {
            $this->arguments = $arguments['__global__'];
            unset($arguments['__global__']);

            if(is_string($this->arguments))
            {
                $this->arguments = array($this->arguments);
            }
        }

        $this->flags     = $arguments;
    }

    public function isEmpty()
    {
        return empty($this->arguments) && empty($this->flags);
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function getArgument($key, $default = null)
    {
        if($this->hasArgument($key))
        {
            return $this->arguments[$key];
        }

        return $default;
    }

    public function hasArgument($key)
    {
        return isset($this->arguments[$key]);
    }

    public function removeArgument($key)
    {
        if($this->hasArgument($key))
        {
            unset($this->arguments[$key]);
            $this->arguments = array_values($this->arguments);
        }
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function getFlag($name, $default = null)
    {
        if($this->hasFlag($name))
        {
            return $this->flags[$name];
        }

        return $default;
    }

    public function hasFlag($name)
    {
        return isset($this->flags[$name]);
    }

    public function removeFlag($key)
    {
        if($this->hasFlag($key))
        {
            unset($this->flags[$key]);
            $this->flags = array_values($this->flags);
        }
    }

}