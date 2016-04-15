<?php

use TM\Console\Console;

/**
 * This function should generate a help for the command.
 * Example:
 *   MyExampleCommand
 *
 *   Its used to be an example. Nothing more, nothing less.
 *
 *   Arguments:
 *     firstname (required) Defines the fistname to say hello.
 *     lastname  (optional) Defines the lastname to say hello.
 *     age:18    (optional) Defines the age for the human.
 *
 *   Flags:
 *	   --uppercase          Write everything in uppercase.
 *     --lowercase          Write everything in lowercase.
 *     --short|-s           Write everything as short as possible.
 *     --size=10			Probably the size of the content written.
 *
 * @return string
 */
class TestCommand extends \CLI\Base\CommandAbstract implements \CLI\Base\CommandInterface
{

    public function configure()
    {
        $this->addArgument('firstname', true)->setDescription('Defines the firstname of to say hello.');
        $this->addArgument('lastname')->setDescription('Defines the lastname to say hello');
        $this->addArgument('age', false, 18)->setDescription('Defines the age for the human');

        $this->addFlag('uppercase')->setDescription('Write everything in uppercase');
        $this->addFlag('lowercase')->setDescription('Write everything in lowercase');
        $this->addFlag('short', 's')->setDescription('Write everything as short as possible.');
        $this->addFlag('size')->setDescription('Probably the size of the content written.')->setDefaultValue(10);
    }

    public function getName()
    {
        return 'TestCommand';
    }

    public function getDescription()
    {
        return 'Its used to be an example. Nothing more, nothing less.';
    }

    public function execute()
    {
        $firstname = $this->getArgument('firstname');
        $lastname  = $this->getArgument('lastname');
        $age       = $this->getArgument('age');

        $isUppercase = $this->hasFlag('uppercase');
        $isLowercase = $this->hasFlag('lowercase');
        $isShort     = $this->hasFlag('short');
        $size        = $this->getFlag('size');

        Console()->out('Firstname: %s', $firstname);
        Console()->out('Lastname: %s', $lastname);

        Console()->out('Age: %d', $age);

        Console()->out('uppercase %s', $isUppercase ? 'true' : 'false');
        Console()->out('lowercase %s', $isLowercase ? 'true' : 'false');
        Console()->out('short %s', $isShort ? 'true' : 'false');
        Console()->out('size: %d', $size);
    }

}