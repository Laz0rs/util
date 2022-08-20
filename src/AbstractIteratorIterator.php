<?php

namespace Laz0r\Util;

use Iterator;
use IteratorAggregate;
use Traversable;

abstract class AbstractIteratorIterator extends AbstractConstructOnce {

	/**
	 * @var \Iterator
	 * @psalm-var \Iterator<array-key, mixed>
	 */
	private Iterator $Iterator;

	/**
	 * @var mixed
	 */
	private $current = null;

	/**
	 * @var mixed
	 */
	private $key = null;

	private bool $valid = false;

	/**
	 * @return void
	 */
	public function __clone() {
		$this->Iterator = clone $this->Iterator;
	}

	/**
	 * @param \Traversable                         $Iterator
	 * @psalm-param \Traversable<array-key, mixed> $Iterator
	 */
	public function __construct(Traversable $Iterator) {
		parent::__construct();

		if ($Iterator instanceof IteratorAggregate) {
			$Iterator = $Iterator->getIterator();
		}

		/** @psalm-var \Iterator<array-key, mixed> $this->Iterator */
		$this->Iterator = $Iterator;
	}

	/**
	 * @return mixed
	 */
	public function current() {
		return $this->current;
	}

	/**
	 * @return mixed
	 */
	public function key() {
		return $this->key;
	}

	/**
	 * @return void
	 */
	public function next() {
		$this->Iterator->next();
		$this->valid = $this->Iterator->valid();

		if ($this->valid) {
			$this->current = $this->Iterator->current();
			$this->key = $this->Iterator->key();
		}
	}

	/**
	 * @return void
	 */
	public function rewind() {
		$this->Iterator->rewind();
		$this->valid = $this->Iterator->valid();

		if ($this->valid) {
			$this->current = $this->Iterator->current();
			$this->key = $this->Iterator->key();
		}
	}

	/**
	 * @return bool
	 */
	public function valid() {
		return $this->valid;
	}

	/**
	 * @return \Iterator
	 * @psalm-return \Iterator<array-key, mixed>
	 */
	protected function getInnerIterator(): Iterator {
		return $this->Iterator;
	}

}

/* vi:set ts=4 sw=4 noet: */
