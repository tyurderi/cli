<?php

namespace CLI\Base;

interface CommandInterface
{

	/**
	 * This function should be used to configure the command.
	 */
	public function configure();

	/**
	 * @return string Name of the command.
	 */
	public function getName();

	/**
	 * @return string Description of command.
	 */
	public function getDescription();

	/**
	 * This function returns the full usage, like the following:
	 *   TestCommand
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
	public function getExtendedUsage();

	/**
	 * This function returns the basic usage, like the following:
	 *
	 * TestCommand <firstname> [lastname] [age=18] [--uppercase] [--lowercase] [--short|-s] [--size=10]
	 *
	 * @return string
	 */
	public function getUsage();

	/**
	 * Adds an argument
	 * 
	 * @param string  $name         Name of the argument
	 * @param boolean $required     Defines if the argument is optional or not.
	 * @param string  $defaultValue Defines the default value if argument is optional.
	 * 
     * @return ArgumentInterface
	 */
	public function addArgument($name, $required = false, $defaultValue = '');

	/**
	 * Checks if the parsed arguments contains an argument with the given name.
	 * 
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function hasArgument($name);

	/**
	 * Retrieve the arguments value, if argument is given
	 *
	 * @param string $name
	 * @param mixed  $default
	 *
	 * @return string|null
	 */
	public function getArgument($name, $default = null);

	/**
	 * Adds a flag
	 *
	 * @param string $name
	 * @param string $shortHand
	 *
	 * @return FlagInterface
	 */
	public function addFlag($name, $shortHand = '');

	/**
	 * Checks if the parsed arguments contains a flag with the given name.
	 *
	 * @param string $name
	 *
	 * @return boolean
	 */
	public function hasFlag($name);

	/**
	 * Retrieve the flags value, if flag is given
	 *
	 * @param string $name
	 * @param mixed  $default
	 *
	 * @return string|boolean|null
	 */
	public function getFlag($name, $default = null);

	/**
	 * The final execute method.
	 */
	public function execute();

}