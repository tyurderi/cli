<?php

namespace CLI\Base;

interface FlagInterface
{

	/**
	 * @return string The name of the flag.
	 */
	public function getName();

	/**
	 * Sets the name of the flag.
	 *
	 * @param string $name
	 *
	 * @return FlagInterface
	 */
	public function setName($name);

	/**
	 * @return string Returns the shorthand of the flag.
	 */
	public function getShortHand();

	/**
	 * Sets the shorthand of the flag.
	 *
	 * @param string $shortHand
	 *
	 * @return FlagInterface
	 */
	public function setShortHand($shortHand);

	/**
	 * @return string The description of the flag. Can be empty.
	 */
	public function getDescription();

	/**
	 * Sets the description of the flag.
	 *
	 * @param string $description
	 *
	 * @return FlagInterface
	 */
	public function setDescription($description);

	/**
	 * @return string The default value of the argument.
	 */
	public function getDefaultValue();

	/**
	 * Sets the default value of the argument.
	 *
	 * @param string $defaultValue
	 *
	 * @return ArgumentInterface
	 */
	public function setDefaultValue($defaultValue);

}