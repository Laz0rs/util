<?php

namespace Laz0r\Util;

class Set implements SetInterface {

	/**
	 * @var mixed[] $items
	 */
	private array $items = [];

	public function add($item): bool {
		$ret = !$this->contains($item);

		if ($ret) {
			$this->push($item);
		}

		return $ret;
	}

	public function clear(): void {
		$this->items = [];
	}

	public function contains($item): bool {
		return in_array($item, $this->items, true);
	}

	public function remove($item): void {
		$this->items = array_diff($this->items, [$item]);
	}

	public function toArray(): array {
		return array_values($this->items);
	}

	/**
	 * @param mixed $item
	 *
	 * @return void
	 */
	protected function push($item): void {
		array_push($this->items, $item);
	}

}

/* vi:set ts=4 sw=4 noet: */
