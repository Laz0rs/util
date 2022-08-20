<?php

namespace Laz0r\Util;

use ArrayAccess;
use EmptyIterator;
use IteratorAggregate;
use Traversable;

/**
 * @template-implements \ArrayAccess<array-key, null>
 * @template-implements \IteratorAggregate<array-key, null>
 */
class Dummy implements ArrayAccess, IteratorAggregate {

	/**
	 * @return \EmptyIterator
	 */
	public function getIterator(): Traversable {
		return new EmptyIterator();
	}

	/**
	 * @param mixed $offset
	 *
	 * @return false
	 */
	public function offsetExists($offset): bool {
		return false;
	}

	/**
	 * @param mixed $offset
	 *
	 * @return null
	 */
	public function offsetGet($offset) {
		return null;
	}

	/**
	 * @param mixed $offset
	 * @param mixed $value
	 *
	 * @return void
	 */
	public function offsetSet($offset, $value): void {
	}

	/**
	 * @param mixed $offset
	 *
	 * @return void
	 */
	public function offsetUnset($offset): void {
	}

}

/* vi:set ts=4 sw=4 noet: */
