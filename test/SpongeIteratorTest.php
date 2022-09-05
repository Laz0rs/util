<?php

namespace Laz0r\UtilTest;

use Generator;
use Laz0r\Util\Exception\OutOfBoundsException;
use Laz0r\Util\SpongeIterator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use SeekableIterator;

/**
 * @coversDefaultClass \Laz0r\Util\SpongeIterator
 */
class SpongeIteratorTest extends TestCase {

	public static function setupBeforeClass(): void {
		require_once __DIR__ . "/../src/Exception/ExceptionInterface.php";
		require_once __DIR__ . "/../src/Exception/OutOfBoundsException.php";
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

	/**
	 * @covers ::seek
	 *
	 * @return void
	 */
	public function testSeekOffset3(): void {
		$Mock = $this->createMock(SeekableIterator::class);
		$Sut = $this->getMockBuilder(SpongeIterator::class)
			->disableOriginalConstructor()
			->onlyMethods(["count", "getInnerIterator", "next", "rewind"])
			->getMock();

		$Mock->expects($this->once())
			->method("seek")
			->with($this->identicalTo(2));
		$Sut->expects($this->once())
			->method("count")
			->will($this->returnValue(42));
		$Sut->expects($this->once())
			->method("getInnerIterator")
			->will($this->returnValue($Mock));
		$Sut->expects($this->once())
			->method("next");
		$Sut->expects($this->never())
			->method("rewind");

		$Sut->seek(3);
	}

	/**
	 * @covers ::seek
	 *
	 * @return void
	 */
	public function testSeekOffsetNegative(): void {
		$Sut = $this->getMockBuilder(SpongeIterator::class)
			->disableOriginalConstructor()
			->onlyMethods(["count", "getInnerIterator", "next", "rewind"])
			->getMock();

		$Sut->expects($this->never())
			->method("count");
		$Sut->expects($this->never())
			->method("getInnerIterator");
		$Sut->expects($this->never())
			->method("next");
		$Sut->expects($this->never())
			->method("rewind");

		$this->expectException(OutOfBoundsException::class);
		$Sut->seek(-1);
	}

	/**
	 * @covers ::seek
	 *
	 * @return void
	 */
	public function testSeekOffsetRediculous(): void {
		$Sut = $this->getMockBuilder(SpongeIterator::class)
			->disableOriginalConstructor()
			->onlyMethods(["count", "getInnerIterator", "next", "rewind"])
			->getMock();

		$Sut->expects($this->once())
			->method("count")
			->will($this->returnValue(42));
		$Sut->expects($this->never())
			->method("getInnerIterator");
		$Sut->expects($this->never())
			->method("next");
		$Sut->expects($this->never())
			->method("rewind");

		$this->expectException(OutOfBoundsException::class);
		$Sut->seek(pow(2, 24));
	}

	/**
	 * @covers ::seek
	 *
	 * @return void
	 */
	public function testSeekOffsetZero(): void {
		$Sut = $this->getMockBuilder(SpongeIterator::class)
			->disableOriginalConstructor()
			->onlyMethods(["count", "getInnerIterator", "next", "rewind"])
			->getMock();

		$Sut->expects($this->never())
			->method("count");
		$Sut->expects($this->never())
			->method("getInnerIterator");
		$Sut->expects($this->never())
			->method("next");
		$Sut->expects($this->once())
			->method("rewind");

		$Sut->seek(0);
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
