<?php

namespace Laz0r\UtilTest;

use Generator;
use Laz0r\Util\SpongeIterator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @coversDefaultClass \Laz0r\Util\SpongeIterator
 */
class SpongeIteratorTest extends TestCase {

	public static function setupBeforeClass(): void {
		require_once __DIR__ . "/../src/AbstractConstructOnce.php";
		require_once __DIR__ . "/../src/AbstractIteratorIterator.php";
		require_once __DIR__ . "/../src/SpongeIterator.php";
	}

	/**
	 * @covers ::__construct
	 * @uses \Laz0r\Util\AbstractIteratorIterator::__construct
	 * @uses \Laz0r\Util\AbstractIteratorIterator::rewind
	 * @uses \Laz0r\Util\AbstractConstructOnce::__construct
	 *
	 * @return \Laz0r\Util\SpongeIterator
	 */
	public function testConstructor(): SpongeIterator {
		$Sut = new SpongeIterator($this->createGenerator());
		$Property = (new ReflectionClass(SpongeIterator::class))
			->getProperty("len");

		$Property->setAccessible(true);

		$this->assertSame(8, $Property->getValue($Sut));

		$Sut->rewind();

		return $Sut;
	}

	/**
	 * @covers ::count
	 * @depends testConstructor
	 *
	 * @param \Laz0r\Util\SpongeIterator $Sut
	 *
	 * @return void
	 */
	public function testCount(SpongeIterator $Sut): void {
		$res = $Sut->count();

		$this->assertSame(8, $res);
	}

	/**
	 * @covers ::current
	 * @depends testConstructor
	 * @uses \Laz0r\Util\AbstractIteratorIterator::current
	 *
	 * @param \Laz0r\Util\SpongeIterator $Sut
	 *
	 * @return void
	 */
	public function testCurrent(SpongeIterator $Sut): void {
		$res = $Sut->current();

		$this->assertSame(9671349, $res);
	}

	/**
	 * @covers ::key
	 * @depends testConstructor
	 * @uses \Laz0r\Util\AbstractIteratorIterator::current
	 *
	 * @param \Laz0r\Util\SpongeIterator $Sut
	 *
	 * @return void
	 */
	public function testKey(SpongeIterator $Sut): void {
		$res = $Sut->key();

		$this->assertSame(2999855, $res);
	}

	private function createGenerator(): Generator {
		yield 2999855 => 9671349;
		yield "BAHAHAHAHAHAHAHAHAHAHA" => "BAHAHAHAHAHAHAHAHAHAHA";
		yield "BAHAHAHAHAHAHAHAHAHAHA" => "BAHAHAHAHAHAHAHAHAHAHA";
		yield "BAHAHAHAHAHAHAHAHAHAHA" => "BAHAHAHAHAHAHAHAHAHAHA";
		yield "BAHAHAHAHAHAHAHAHAHAHA" => "BAHAHAHAHAHAHAHAHAHAHA";
		yield "BAHAHAHAHAHAHAHAHAHAHA" => "BAHAHAHAHAHAHAHAHAHAHA";
		yield "BAHAHAHAHAHAHAHAHAHAHA" => "BAHAHAHAHAHAHAHAHAHAHA";
		yield "BAHAHAHAHAHAHAHAHAHAHA" => "BAHAHAHAHAHAHAHAHAHAHA";
	}

}

/* vi:set ts=4 sw=4 noet: */
