<?php

namespace Laz0r\Util;

use ArrayIterator;
use Countable;
use Iterator;

class SpongeIterator extends AbstractIteratorIterator implements
	Countable,
	Iterator {

	private int $len;

	/**
	 * @param iterable $iterable
	 */
	public function __construct(iterable $iterable) {
		$buffer = [];

		/**
		 * @var mixed $key
		 * @psalm-var array-key $key
		 * @var mixed $value
		 */
		foreach ($iterable as $key => $value) {
			$buffer[] = [$key, $value];
		}

		parent::__construct(new ArrayIterator($buffer));

		$this->len = count($buffer);
	}

	public function count(): int {
		return $this->len;
	}

	public function current() {
		/** @var array $res */
		$res = parent::current();

		assert(array_key_exists(1, $res));

		return $res[1];
	}

	public function key() {
		/** @var array $res */
		$res = parent::current();

		assert(array_key_exists(0, $res));

		return $res[0];
	}

}

/* vi:set ts=4 sw=4 noet: */
