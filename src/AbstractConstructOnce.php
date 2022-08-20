<?php

namespace Laz0r\Util;

use Laz0r\Util\Exception\LogicException;

/**
 * Base for classes whose constructor must be called only once.
 *
 * @see https://wiki.php.net/rfc/disallow-multiple-constructor-calls
 */
abstract class AbstractConstructOnce {

	private bool $_constructed = false;

	/**
	 * Constructor.
	 *
	 * @throws \Laz0r\Util\Exception\LogicException
	 */
	public function __construct() {
		if ($this->_constructed) {
			throw new LogicException("Invalid call to __construct()");
		}

		$this->_constructed = true;
	}

}

/* vi:set ts=4 sw=4 noet: */
