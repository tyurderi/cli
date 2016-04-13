<?php

namespace CLI\Base;

interface ArgumentInterface
{

	/**
	 * @return string The name of the argument.
	 */
	public function getName();

	/**
	 * Sets the name of the argument.
	 *
	 * @param string $name
	 *
	 * @return ArgumentInterface
	 */
	public function setName($name);

	/**
	 * @return string The description of the argument. Can be empty.
	 */
	public function getDescription();

	/**
	 * Sets the description of the argument.
	 *
	 * @param string $description
	 *
	 * @return ArgumentInterface
	 */
	public function setDescription($description);

	/**
	 * @return boolean
	 */
	public function getRequired();

	/**
	 * Sets the argument required or not.
	 *
	 * @param boolean $required
	 *
	 * @return ArgumentInterface
	 */
	public function setRequired($required);

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