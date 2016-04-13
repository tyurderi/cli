<?php

namespace CLI\Base;

use WCKZ\Generator\FileBuilder;

abstract class CommandAbstract implements CommandInterface
{

    /**
     * @var Argument[]
     */
    private $arguments;

    /**
     * @var array
     */
    private $parsedArguments;

    /**
     * @var Flag[]
     */
    private $flags;

    /**
     * @var array
     */
    private $parsedFlags;

    public function __construct()
    {
        $this->arguments       = array();
        $this->parsedArguments = array();

        $this->flags           = array();
        $this->parsedFlags     = array();
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function setParsedArguments($parsedArguments)
    {
        $this->parsedArguments = $parsedArguments;

        return $this;
    }

    public function setParsedFlags($parsedFlags)
    {
        $this->parsedFlags = $parsedFlags;

        return $this;
    }

    /**
     * MyExampleCommand
     *
     * Its used to be an example. Nothing more, nothing less.
     *
     * Arguments:
     *   firstname (required) Defines the fistname to say hello.
     *   lastname  (optional) Defines the lastname to say hello.
     *   age=18    (optional) Defines the age for the human.
     *
     * Flags:
     *   --uppercase          Write everything in uppercase.
     *   --lowercase          Write everything in lowercase.
     *   --short|-s           Write everything as short as possible.
     *   --size=10			Probably the size of the content written.
     */
    public function getExtendedUsage()
    {
        $usage = new FileBuilder();
        $usage->add($this->getName());
        $usage->newLine(2);
        $usage->add($this->getDescription());
        $usage->newLine();

        if($arguments = $this->getArguments())
        {
            $usage->newLine()->add('Arguments:')->newLine();

            foreach($arguments as $argument)
            {
                $name = $argument->getName();
                if($argument->getDefaultValue())
                {
                    $name .= '=' . $argument->getDefaultValue();
                }
                $usage->add('  %-11s %-11s %s', $name, $argument->getRequired() ? '' : '(optional)',
                    $argument->getDescription());

                $usage->newLine();
            }
        }

        if($flags = $this->getFlags())
        {
            $usage->newLine()->add('Flags:')->newLine();

            foreach($flags as $flag)
            {
                $name = $flag->getName();
                if($flag->getShortHand())
                {
                    $name .= '|-' . $flag->getShortHand();
                }

                if($flag->getDefaultValue())
                {
                    $name .= '=' . $flag->getDefaultValue();
                }

                $usage->add('  --%-21s %s', $name, $flag->getDescription())->newLine();
            }
        }

        return $usage;
    }

    /**
     * TestCommand <firstname> [lastname] [age=18] [--uppercase] [--lowercase] [--short|-s] [--size=10]
     */
    public function getUsage()
    {
        $usage = $this->getName();

        foreach($this->getArguments() as $argument)
        {
            if($argument->getRequired())
            {
                $usage .= sprintf(' <%s>', $argument->getName());
            }
            else
            {
                $usage .= sprintf(
                    ' [%s%s]',
                    $argument->getName(),
                    $argument->getDefaultValue() ? '=' .$argument->getDefaultValue() : ''
                );
            }
        }

        foreach($this->getFlags() as $flag)
        {
            $usage .= ' [--' . $flag->getName();

            if($flag->getShortHand())
            {
                $usage .= '|-' . $flag->getShortHand();
            }

            if($flag->getDefaultValue())
            {
                $usage .= '=' . $flag->getDefaultValue();
            }

            $usage .= ']';
        }

        return $usage;
    }

    public function addArgument($name, $required = false, $defaultValue = '')
    {
        $argument = new Argument();
        $argument->setName($name);
        $argument->setRequired($required);
        $argument->setDefaultValue($defaultValue);

        $this->arguments[] = $argument;

        return $argument;
    }

    public function hasArgument($name)
    {
        return isset($this->parsedArguments[$name]);
    }

    public function getArgument($name, $default = null)
    {
        if($this->hasArgument($name))
        {
            return $this->parsedArguments[$name];
        }

        return $default;
    }

    public function addFlag($name, $shortHand = '')
    {
        $flag = new Flag();
        $flag->setName($name);
        $flag->setShortHand($shortHand);

        $this->flags[] = $flag;

        return $flag;
    }

    public function hasFlag($name)
    {
        return isset($this->parsedFlags[$name]);
    }

    public function getFlag($name, $default = null)
    {
        if($this->hasFlag($name))
        {
            return $this->parsedFlags[$name];
        }

        return $default;
    }

}