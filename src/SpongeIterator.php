<?php

namespace Laz0r\Util;

use ArrayIterator;
use Countable;
use Laz0r\Util\Exception\OutOfBoundsException;
use SeekableIterator;

class SpongeIterator extends AbstractIteratorIterator implements
	Countable,
	SeekableIterator {

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

	public function seek(int $offset): void {
		if ($offset === 0) {
			$this->rewind();

			return;
		}

		if (($offset < 0) || ($offset >= $this->count())) {
			throw new OutOfBoundsException("Invalid offset");
		}

		$AI = $this->getInnerIterator();

		assert($AI instanceof SeekableIterator);

		$AI->seek($offset - 1);
		$this->next();
	}

}

/* vi:set ts=4 sw=4 noet: */
