<?php

namespace Laz0r\Util;

interface SetInterface {

	/**
	 * @param mixed $item
	 *
	 * @return bool
	 */
	public function add($item): bool;

	/**
	 * @return void
	 */
	public function clear(): void;

	/**
	 * @param mixed $item
	 *
	 * @return bool
	 */
	public function contains($item): bool;

	/**
	 * @param mixed $item
	 *
	 * @return void
	 */
	public function remove($item): void;

	/**
	 * @return mixed[]
	 */
	public function toArray(): array;

}

/* vi:set ts=4 sw=4 noet: */
