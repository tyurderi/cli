<?php

namespace CLI\Base;

class Flag implements FlagInterface
{

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $shortHand;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var boolean
	 */
	private $required;

	/**
	 * @var string
	 */
	private $defaultValue;

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	public function getShortHand()
	{
		return $this->shortHand;
	}

	public function setShortHand($shortHand)
	{
		$this->shortHand = $shortHand;

		return $this;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	public function getRequired()
	{
		return $this->required;
	}

	public function setRequired($required)
	{
		$this->required = $required;

		return $this;
	}

	public function getDefaultValue()
	{
		return $this->defaultValue;
	}

	public function setDefaultValue($defaultValue)
	{
		$this->defaultValue = $defaultValue;

		return $this;
	}

}