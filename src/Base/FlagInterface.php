<?php

namespace CLI\Base;

interface FlagInterface extends ArgumentInterface
{

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

}