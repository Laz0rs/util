<?php

namespace Laz0r\Util;

use ArrayAccess;
use ArrayObject;
use Countable;
use IteratorAggregate;
use Serializable;
use Traversable;
use const SORT_REGULAR;

/**
 * @template-implements \ArrayAccess<array-key, mixed>
 * @template-implements \IteratorAggregate<array-key, mixed>
 */
abstract class AbstractArrayObject implements
	ArrayAccess,
	Countable,
	IteratorAggregate,
	Serializable {

	private ?ArrayObject $Storage = null;

	/**
	 * @return int
	 */
	public function count(): int {
		return $this->getStorage()->count();
	}

	/**
	 * @param array $input
	 *
	 * @return array
	 */
	public function exchangeArray(array $input): array {
		$ret = $this->getStorage()->getArrayCopy();

		$this->getStorage()->exchangeArray($input);

		return $ret;
	}

	/**
	 * @return array
	 */
	public function getArrayCopy(): array {
		return $this->getStorage()->getArrayCopy();
	}

	/**
	 * @return \ArrayIterator
	 */
	public function getIterator(): Traversable {
		return $this->getStorage()->getIterator();
	}

	/**
	 * @param mixed $offset
	 *
	 * @return bool
	 */
	public function offsetExists($offset): bool {
		return $this->getStorage()->offsetExists($offset);
	}

	/**
	 * @param mixed $offset
	 *
	 * @return mixed
	 */
	public function offsetGet($offset) {
		return $this->getStorage()->offsetGet($offset);
	}

	/**
	 * @param mixed $offset
	 * @param mixed $value
	 *
	 * @return void
	 */
	public function offsetSet($offset, $value): void {
		$this->getStorage()->offsetSet($offset, $value);
	}

	/**
	 * @param mixed $offset
	 *
	 * @return void
	 */
	public function offsetUnset($offset): void {
		$this->getStorage()->offsetUnset($offset);
	}

	/**
	 * @return string
	 */
	public function serialize(): string {
		return serialize($this->Storage);
	}

	/**
	 * @param string $serialized
	 *
	 * @return void
	 */
	public function unserialize($serialized): void {
		$Storage = unserialize($serialized);

		assert($Storage instanceof ArrayObject);

		$this->Storage = $Storage;
	}

	/**
	 * @param mixed $value
	 *
	 * @return void
	 */
	protected function append($value): void {
		$this->getStorage()->append($value);
	}

	/**
	 * @param int $flags
	 *
	 * @return void
	 */
	protected function asort(int $flags = SORT_REGULAR): void {
		/** @psalm-suppress TooManyArguments */
		$this->getStorage()->asort($flags);
	}

	/**
	 * @return string
	 * @psalm-return class-string
	 */
	protected function getIteratorClass(): string {
		return $this->getStorage()->getIteratorClass();
	}

	/**
	 * @param int $flags
	 *
	 * @return void
	 */
	protected function ksort(int $flags = SORT_REGULAR): void {
		/** @psalm-suppress TooManyArguments */
		$this->getStorage()->ksort($flags);
	}

	/**
	 * @return void
	 */
	protected function natcasesort(): void {
		$this->getStorage()->natcasesort();
	}

	/**
	 * @return void
	 */
	protected function natsort(): void {
		$this->getStorage()->natsort();
	}

	/**
	 * @param string $iterator_class
	 * @psalm-param class-string<\ArrayIterator> $iterator_class
	 *
	 * @return void
	 */
	protected function setIteratorClass(string $iterator_class): void {
		$this->getStorage()->setIteratorClass($iterator_class);
	}

	/**
	 * @param callable $cmp_function
	 * @psalm-param callable(mixed, mixed):int $cmp_function
	 *
	 * @return void
	 */
	protected function uasort(callable $cmp_function): void {
		$this->getStorage()->uasort($cmp_function);
	}

	/**
	 * @param callable $cmp_function
	 * @psalm-param callable(mixed, mixed):int $cmp_function
	 *
	 * @return void
	 */
	protected function uksort(callable $cmp_function): void {
		$this->getStorage()->uksort($cmp_function);
	}

	/**
	 * @return \ArrayObject
	 */
	private function getStorage(): ArrayObject {
		$this->Storage ??= new ArrayObject();

		return $this->Storage;
	}

}

/* vi:set ts=4 sw=4 noet: */
