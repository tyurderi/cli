<?php

namespace CLI;

use CLI\Base\CommandAbstract;
use TM\Console\Console;

class App
{

    /**
     * @var CommandAbstract[]
     */
    private $commands;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $name;

    public function __construct($version = 'undefined', $name = '')
    {
        $this->commands = array();
        $this->version  = $version;
        $this->name     = $name;
    }

    /**
     * Function ro register commands
     *
     * @param $command
     *
     * @throws \InvalidArgumentException
     */
    public function register($command)
    {
        if($command instanceof CommandAbstract)
        {
            $this->commands[] = $command;
        }
        else if(is_array($command))
        {
            foreach($command as $subCommand)
            {
                $this->register($subCommand);
            }
        }
        else
        {
            throw new \InvalidArgumentException('$command must extend CLI\Base\CommandAbstract');
        }
    }

    /**
     * Final function to run the cli application.
     *
     * @param array $args Should be "array_splice($argv, 1)"
     */
    public function run($args)
    {
        $result = $this->parseArguments($args);

        if($result->isEmpty() || ($result->hasFlag('help') && $result->hasArgument(0) === false))
        {
            $this->showHelp();
        }
        else if($result->hasFlag('help') && $result->hasArgument(0))
        {
            $this->showCommandUsage($result->getArgument(0));
        }
        else if($result->hasFlag('version') && $result->hasArgument(0) === false)
        {
            if(!empty($this->name))
            {
                Console::writeLine('%s (v%s)', $this->name, $this->version);
            }
            else
            {
                Console::writeLine('Version %s', $this->version);
            }
        }
        else
        {
            $commandName = $result->getArgument(0);

            if($command = $this->getCommandByName($commandName))
            {
                $result = $this->parseArguments(array_splice($args, 1));

                $this->executeCommand($command, $result);
            }
            else
            {
                Console::writeLine('Unknown command: %s.', $commandName);
            }
        }
    }

    /**
     * Wrapper function to parse arguments.
     *
     * @param $args
     *
     * @return \CLI\Arguments
     */
    public function parseArguments($args)
    {
        $parser = new \CliParser\Cli\PostParser();
        $parsed = $parser->parse($args);

        return new Arguments($parsed);
    }

    /**
     * Wrapper function to execute a command with parsed arguments and flags.
     *
     * @param \CLI\Base\CommandAbstract $command
     * @param \CLI\Arguments            $arguments
     */
    public function executeCommand(CommandAbstract $command, Arguments $arguments)
    {
        $this->prepareCommandArguments($command, $arguments);

        $command->execute();
    }

    /**
     * Checks for valid command arguments and flags.
     *
     * First checks if required arguments exists, if not show simple command usage.
     * Anything else will be added to the parsed arguments.
     *
     * Secondly checks if the given flags exists for the command. Will show simple command usage if not.
     * Adds flags values to the parsed flags and applies the gained data to the command for executing.
     *
     * @param \CLI\Base\CommandAbstract $command
     * @param \CLI\Arguments            $arguments
     */
    public function prepareCommandArguments(CommandAbstract $command, Arguments $arguments)
    {
        $parsedArguments = array();
        $parsedFlags     = array();

        $command->configure();

        // check arguments
        foreach($command->getArguments() as $i => $argument)
        {
            $value = null;

            if($argument->getRequired() && $arguments->hasArgument($i))
            {
                $value = $arguments->getArgument($i);
            }
            else if($argument->getRequired() === false)
            {
                $value = $arguments->getArgument($i, $argument->getDefaultValue());
            }
            else
            {
                $this->showUsage($command->getUsage());
                Console::stop();
            }

            $parsedArguments[$argument->getName()] = $value;
        }

        // check flags
        foreach($arguments->getFlags() as $flagName => $value)
        {
            $flagFound = false;

            foreach($command->getFlags() as $flag)
            {
                if(in_array($flagName, array($flag->getName(), $flag->getShortHand())))
                {
                    $parsedFlags[$flag->getName()] = $value;
                    $flagFound = true;
                    break;
                }
            }

            if(!$flagFound)
            {
                $this->showUsage($command->getUsage());
                Console::stop();
            }
        }

        $command->setParsedArguments($parsedArguments);
        $command->setParsedFlags($parsedFlags);
    }

    /**
     * Helper to write any usage.
     *
     * @param $usage
     */
    public function showUsage($usage)
    {
        Console::writeLine('Usage: %s %s', basename($_SERVER['PHP_SELF']), $usage);
    }

    /**
     * Show basic usage and list available commands.
     */
    public function showHelp()
    {
        $this->showUsage('<command> [--help]');

        Console::newLine();
        Console::writeLine('Available commands:');

        foreach($this->commands as $command)
        {
            Console::writeLine('    %s', $command->getName());
            Console::writeLine('        %s', $command->getDescription());
        }
    }

    /**
     * Show extended usage for command, if command exist.
     *
     * @param string $commandName
     */
    public function showCommandUsage($commandName)
    {
        if($command = $this->getCommandByName($commandName))
        {
            $command->configure();

            Console::writeLine($command->getExtendedUsage());
        }
        else
        {
            Console::writeLine('Unknown command: %s.', $commandName);
        }
    }

    /**
     * @param string $name
     *
     * @return \CLI\Base\CommandAbstract|null
     */
    protected function getCommandByName($name)
    {
        foreach($this->commands as $command)
        {
            if($command->getName() === $name)
            {
                return $command;
            }
        }

        return null;
    }

}