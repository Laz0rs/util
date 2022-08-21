<?php

namespace Laz0r\UtilTest;

use Laz0r\Util\AbstractConstructOnce;
use Laz0r\Util\Exception\LogicException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @coversDefaultClass \Laz0r\Util\AbstractConstructOnce
 */
class AbstractConstructOnceTest extends TestCase {

	public static function setupBeforeClass(): void {
		require_once __DIR__ . "/../src/Exception/ExceptionInterface.php";
		require_once __DIR__ . "/../src/Exception/LogicException.php";
		require_once __DIR__ . "/../src/AbstractConstructOnce.php";
	}

	/**
	 * @coversNothing
	 *
	 * @return void
	 */
	public function testConstructedDefaultFalse(): void {
		$Sut = $this->getMockBuilder(AbstractConstructOnce::class)
			->disableOriginalConstructor()
			->getMock();
		$Property = (new ReflectionClass(AbstractConstructOnce::class))
			->getProperty("_constructed");

		$Property->setAccessible(true);
		$this->assertFalse($Property->getValue($Sut));
	}

	/**
	 * @covers ::__construct
	 *
	 * @return void
	 */
	public function testConstructorSetsConstructed(): void {
		$Sut = $this->getMockBuilder(AbstractConstructOnce::class)
			->disableOriginalConstructor()
			->getMock();
		$Property = (new ReflectionClass(AbstractConstructOnce::class))
			->getProperty("_constructed");

		$Property->setAccessible(true);
		$Sut->__construct();
		$this->assertTrue($Property->getValue($Sut));
	}

	/**
	 * @covers ::__construct
	 *
	 * @return void
	 */
	public function testConstructorThrowsException(): void {
		$Sut = $this->getMockBuilder(AbstractConstructOnce::class)
			->disableOriginalConstructor()
			->getMock();
		$Property = (new ReflectionClass(AbstractConstructOnce::class))
			->getProperty("_constructed");

		$Property->setAccessible(true);
		$Property->setValue($Sut, true);
		$this->expectException(LogicException::class);
		$Sut->__construct();
	}

}

/* vi:set ts=4 sw=4 noet: */
