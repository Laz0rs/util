<?php

namespace Laz0r\Util;

use ReflectionClass;

trait CreateObjectTrait {

	/**
	 * @param string $qcn
	 * @param mixed  ...$args
	 *
	 * @return object of type $qcn
	 */
	protected function createObject(string $qcn, ...$args): object {
		assert(class_exists($qcn));

		$RC = new ReflectionClass($qcn);

		return $RC->newInstanceArgs(array_values($args));
	}

}

/* vi:set ts=4 sw=4 noet: */
