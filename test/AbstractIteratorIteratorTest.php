<?php

namespace Laz0r\UtilTest;

use ArrayIterator;
use ArrayObject;
use Iterator;
use Laz0r\Util\AbstractIteratorIterator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @coversDefaultClass \Laz0r\Util\AbstractIteratorIterator
 */
class AbstractIteratorIteratorTest extends TestCase {

	public static function setupBeforeClass(): void {
		require_once __DIR__ . "/../src/Exception/ExceptionInterface.php";
		require_once __DIR__ . "/../src/Exception/LogicException.php";
		require_once __DIR__ . "/../src/AbstractConstructOnce.php";
		require_once __DIR__ . "/../src/AbstractIteratorIterator.php";
	}

	/**
	 * @covers ::__clone
	 *
	 * @return void
	 */
	public function testClone(): void {
		$Stub = $this->createStub(ArrayIterator::class);
		$Sut = $this->getMockBuilder(AbstractIteratorIterator::class)
			->disableOriginalClone()
			->disableOriginalConstructor()
			->getMock();
		$RC = new ReflectionClass(AbstractIteratorIterator::class);
		$Property = $RC->getProperty("Iterator");
		$Method = $RC->getMethod("__clone");

		$Property->setAccessible(true);
		$Property->setValue($Sut, $Stub);
		$Method->invokeArgs($Sut, []);

		$this->assertNotSame($Stub, $Property->getValue($Sut));
		$this->assertIsObject($Property->getValue($Sut));
		$this->assertInstanceOf(ArrayIterator::class, $Property->getValue($Sut));
	}

	/**
	 * @covers ::__construct
	 * @uses \Laz0r\Util\AbstractConstructOnce
	 *
	 * @return void
	 */
	public function testConstructorWithIterator(): void {
		$Stub = call_user_func(static function() {
			while (true) {
				yield null;
			}
		});
		$Sut = $this->getMockBuilder(AbstractIteratorIterator::class)
			->disableOriginalClone()
			->disableOriginalConstructor()
			->getMock();
		$Property = (new ReflectionClass(AbstractIteratorIterator::class))
			->getProperty("Iterator");

		$Sut->__construct($Stub);
		$Property->setAccessible(true);
		$this->assertSame($Stub, $Property->getValue($Sut));
	}

	/**
	 * @covers ::__construct
	 * @uses \Laz0r\Util\AbstractConstructOnce
	 *
	 * @return void
	 */
	public function testConstructorWithIteratorAggregate(): void {
		$Stub = $this->createStub(Iterator::class);
		$Mock = $this->createMock(ArrayObject::class);
		$Sut = $this->getMockBuilder(AbstractIteratorIterator::class)
			->disableOriginalClone()
			->disableOriginalConstructor()
			->getMock();
		$Property = (new ReflectionClass(AbstractIteratorIterator::class))
			->getProperty("Iterator");

		$Mock->expects($this->once())
			->method("getIterator")
			->willReturn($Stub);
		$Sut->__construct($Mock);
		$Property->setAccessible(true);
		$this->assertSame($Stub, $Property->getValue($Sut));
	}

	/**
	 * @covers ::current
	 *
	 * @return void
	 */
	public function testCurrent(): void {
		$Stub = (object)[];
		$Sut = new class() extends AbstractIteratorIterator {

			public function __construct() {
			}

		};
		$Property = (new ReflectionClass(AbstractIteratorIterator::class))
			->getProperty("current");

		$Property->setAccessible(true);
		$Property->setValue($Sut, $Stub);

		$Result = $Sut->current();

		$this->assertSame($Stub, $Result);
	}

	/**
	 * @covers ::key
	 *
	 * @return void
	 */
	public function testKey(): void {
		$Stub = (object)[];
		$Sut = new class() extends AbstractIteratorIterator {

			public function __construct() {
			}

		};
		$Property = (new ReflectionClass(AbstractIteratorIterator::class))
			->getProperty("key");

		$Property->setAccessible(true);
		$Property->setValue($Sut, $Stub);

		$Result = $Sut->key();

		$this->assertSame($Stub, $Result);
	}

	/**
	 * @covers ::next
	 *
	 * @return void
	 */
	public function testNextInvalid(): void {
		$Mock = $this->createMock(Iterator::class);
		$Sut = new class() extends AbstractIteratorIterator {

			public function __construct() {
			}

		};
		$RC = new ReflectionClass(AbstractIteratorIterator::class);
		$Iterator = $RC->getProperty("Iterator");
		$Valid = $RC->getProperty("valid");

		$Mock->expects($this->once())
			->method("next");
		$Mock->expects($this->once())
			->method("valid")
			->willReturn(false);
		$Mock->expects($this->never())
			->method("current");
		$Mock->expects($this->never())
			->method("key");
		$Iterator->setAccessible(true);
		$Iterator->setValue($Sut, $Mock);
		$Valid->setAccessible(true);
		$Valid->setValue($Sut, true);

		$Sut->next();

		$this->assertFalse($Valid->getValue($Sut));
	}

	/**
	 * @covers ::next
	 *
	 * @return void
	 */
	public function testNextValid(): void {
		$Stub0 = (object)[];
		$Stub1 = (object)[];

		$Mock = $this->createMock(Iterator::class);
		$Sut = new class() extends AbstractIteratorIterator {

			public function __construct() {
			}

		};
		$RC = new ReflectionClass(AbstractIteratorIterator::class);
		$Current = $RC->getProperty("current");
		$Iterator = $RC->getProperty("Iterator");
		$Key = $RC->getProperty("key");
		$Valid = $RC->getProperty("valid");

		$Mock->expects($this->once())
			->method("next");
		$Mock->expects($this->once())
			->method("valid")
			->willReturn(true);
		$Mock->expects($this->once())
			->method("current")
			->willReturn($Stub0);
		$Mock->expects($this->once())
			->method("key")
			->willReturn($Stub1);
		$Current->setAccessible(true);
		$Iterator->setAccessible(true);
		$Iterator->setValue($Sut, $Mock);
		$Key->setAccessible(true);
		$Valid->setAccessible(true);

		$Sut->next();

		$this->assertSame($Stub0, $Current->getValue($Sut));
		$this->assertSame($Stub1, $Key->getValue($Sut));
		$this->assertTrue($Valid->getValue($Sut));
	}

	/**
	 * @covers ::rewind
	 *
	 * @return void
	 */
	public function testRewindInvalid(): void {
		$Mock = $this->createMock(Iterator::class);
		$Sut = new class() extends AbstractIteratorIterator {

			public function __construct() {
			}

		};
		$RC = new ReflectionClass(AbstractIteratorIterator::class);
		$Iterator = $RC->getProperty("Iterator");
		$Valid = $RC->getProperty("valid");

		$Mock->expects($this->once())
			->method("rewind");
		$Mock->expects($this->once())
			->method("valid")
			->willReturn(false);
		$Mock->expects($this->never())
			->method("current");
		$Mock->expects($this->never())
			->method("key");
		$Iterator->setAccessible(true);
		$Iterator->setValue($Sut, $Mock);
		$Valid->setAccessible(true);
		$Valid->setValue($Sut, true);

		$Sut->rewind();

		$this->assertFalse($Valid->getValue($Sut));
	}

	/**
	 * @covers ::rewind
	 *
	 * @return void
	 */
	public function testRewindValid(): void {
		$Stub0 = (object)[];
		$Stub1 = (object)[];

		$Mock = $this->createMock(Iterator::class);
		$Sut = new class() extends AbstractIteratorIterator {

			public function __construct() {
			}

		};
		$RC = new ReflectionClass(AbstractIteratorIterator::class);
		$Current = $RC->getProperty("current");
		$Iterator = $RC->getProperty("Iterator");
		$Key = $RC->getProperty("key");
		$Valid = $RC->getProperty("valid");

		$Mock->expects($this->once())
			->method("rewind");
		$Mock->expects($this->once())
			->method("valid")
			->willReturn(true);
		$Mock->expects($this->once())
			->method("current")
			->willReturn($Stub0);
		$Mock->expects($this->once())
			->method("key")
			->willReturn($Stub1);
		$Current->setAccessible(true);
		$Iterator->setAccessible(true);
		$Iterator->setValue($Sut, $Mock);
		$Key->setAccessible(true);
		$Valid->setAccessible(true);

		$Sut->rewind();

		$this->assertSame($Stub0, $Current->getValue($Sut));
		$this->assertSame($Stub1, $Key->getValue($Sut));
		$this->assertTrue($Valid->getValue($Sut));
	}

	/**
	 * @covers ::valid
	 *
	 * @return void
	 */
	public function testValid(): void {
		$Sut = new class() extends AbstractIteratorIterator {

			public function __construct() {
			}

		};
		$Property = (new ReflectionClass(AbstractIteratorIterator::class))
			->getProperty("valid");

		$Property->setAccessible(true);
		$Property->setValue($Sut, true);

		$result = $Sut->valid();

		$this->assertTrue($result);
	}

	/**
	 * @covers ::getInnerIterator
	 *
	 * @return void
	 */
	public function testGetInnerIterator(): void {
		$Stub = call_user_func(static function() {
			while (true) {
				yield null;
			}
		});
		$Sut = new class() extends AbstractIteratorIterator {

			public function __construct() {
			}

		};
		$RC = new ReflectionClass(AbstractIteratorIterator::class);
		$Method = $RC->getMethod("getInnerIterator");
		$Property = $RC->getProperty("Iterator");

		$Property->setAccessible(true);
		$Property->setValue($Sut, $Stub);
		$Method->setAccessible(true);

		$Result = $Method->invokeArgs($Sut, []);

		$this->assertSame($Stub, $Result);
	}

}

/* vi:set ts=4 sw=4 noet: */
