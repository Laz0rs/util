<?php

namespace Laz0r\UtilTest;

use Iterator;
use Laz0r\Util\{AbstractIteratorIterator, IteratorIterator};
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @coversDefaultClass \Laz0r\Util\IteratorIterator
 */
class IteratorIteratorTest extends TestCase {

	public static function setupBeforeClass(): void {
		require_once __DIR__ . "/../src/Exception/ExceptionInterface.php";
		require_once __DIR__ . "/../src/Exception/LogicException.php";
		require_once __DIR__ . "/../src/AbstractConstructOnce.php";
		require_once __DIR__ . "/../src/AbstractIteratorIterator.php";
		require_once __DIR__ . "/../src/IteratorIterator.php";
	}

	/**
	 * @covers ::getInnerIterator
	 * @uses \Laz0r\Util\AbstractIteratorIterator::getInnerIterator
	 *
	 * @return void
	 */
	public function testGetInnerIterator(): void {
		$Stub = $this->createStub(Iterator::class);
		$Sut = (new ReflectionClass(IteratorIterator::class))
			->newInstanceWithoutConstructor();
		$Property = (new ReflectionClass(AbstractIteratorIterator::class))
			->getProperty("Iterator");

		$Property->setAccessible(true);
		$Property->setValue($Sut, $Stub);

		$Result = $Sut->getInnerIterator();

		$this->assertSame($Stub, $Result);
	}

}

/* vi:set ts=4 sw=4 noet: */
