<?php

namespace Laz0r\UtilTest;

use EmptyIterator;
use Laz0r\Util\Dummy;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Laz0r\Util\Dummy
 */
class DummyTest extends TestCase {

	public static function setupBeforeClass(): void {
		require_once __DIR__ . "/../src/Dummy.php";
	}

	/**
	 * @covers ::getIterator
	 *
	 * @return void
	 */
	public function testGetIterator(): void {
		$Sut = new Dummy();
		$Result = $Sut->getIterator();

		$this->assertInstanceOf(EmptyIterator::class, $Result);
	}

	/**
	 * @covers ::offsetExists
	 *
	 * @return void
	 */
	public function testOffsetExists(): void {
		$Sut = new Dummy();
		$result = $Sut->offsetExists(13);

		$this->assertFalse($result);
	}

	/**
	 * @covers ::offsetGet
	 *
	 * @return void
	 */
	public function testOffsetGet(): void {
		$Sut = new Dummy();
		$result = $Sut->offsetGet(37);

		$this->assertNull($result);
	}

}

/* vi:set ts=4 sw=4 noet: */
