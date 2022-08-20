<?php

namespace Laz0r\Util;

use Iterator;
use OuterIterator;

/**
 * @template-implements \OuterIterator<array-key, mixed>
 */
class IteratorIterator extends AbstractIteratorIterator implements OuterIterator {

	public function getInnerIterator(): Iterator {
		return parent::getInnerIterator();
	}

}

/* vi:set ts=4 sw=4 noet: */
