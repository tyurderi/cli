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
     * Usage: TestCommand <firstname> [lastname] [age (default: 18)] [--uppercase] [--lowercase] [-s, --short] [--size (default: 10)]
     *
     * Required Arguments:
     *     firstname
     *         Defines the firstname to say hello.
     *
     * Optional Arguments:
     *     lastname
     *         Defines the lastname to say hello.
     *     age (default: 18)
     *         Defines the age for the human.
     *     --uppercase
     *         Write everything in uppercase.
     *     --lowercase
     *         Write everything in lowercase.
     *     -s, --short
     *         Write everything as short as possible.
     *     --size (default: 10)
     *         Probably the size of the content written.
     *
     * Description:
     *     Its used to be an example. Nothing more, nothing less.
     */
    public function getExtendedUsage()
    {
        $usage = new FileBuilder();
        $usage->add($this->getName())->newLine(2);

        if($this->getDescription())
        {
            $usage->add($this->getDescription())->newLine(2);
        }

        $usage->add('Usage: %s', $this->getUsage())->newLine(2);

        $required = new FileBuilder();
        $optional = new FileBuilder();
        foreach($this->getArguments() as $argument)
        {
            $tmp = $argument->getRequired() ? $required : $optional;

            $tmp->indent()->add($argument->getName());

            if($argument->getDefaultValue())
            {
                $tmp->add(' (default: %s)', $argument->getDefaultValue());
            }

            $tmp->newLine();

            if($argument->getDescription())
            {
                $tmp->indent(2)->add($argument->getDescription())->newLine();
            }
        }

        foreach($this->getFlags() as $flag)
        {
            $tmp = $flag->getRequired() ? $required : $optional;

            $tmp->indent();
            if($flag->getShortHand())
            {
                $tmp->add('-%s, ', $flag->getShortHand());
            }

            $tmp->add('--%s', $flag->getName());

            if($flag->getDefaultValue())
            {
                $tmp->add(' (default: %s)', $flag->getDefaultValue());
            }

            $tmp->newLine();

            if($flag->getDescription())
            {
                $tmp->indent(2)->add($flag->getDescription())->newLine();
            }
        }

        if(!empty($required))
        {
            $usage->add('Required Arguments:')->newLine()->add($required)->newLine();
        }

        if(!empty($optional))
        {
            $usage->add('Optional Arguments:')->newLine()->add($optional);
        }

        return $usage;
    }

    /**
     * TestCommand <firstname> [lastname] [age (default: 18)] [--uppercase] [--lowercase] [-s, --short] [--size] (default: 10)]
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
                    $argument->getDefaultValue() ? sprintf(' (default: %s)', $argument->getDefaultValue()) : ''
                );
            }
        }

        foreach($this->getFlags() as $flag)
        {
            if($flag->getShortHand())
            {
                $usage .= ' [-' . $flag->getShortHand() . ', ';
            }
            else
            {
                $usage .= ' [';
            }

            $usage .= '--' . $flag->getName();

            if($flag->getDefaultValue())
            {
                $usage .= sprintf(' (default: %s)', $flag->getDefaultValue());
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