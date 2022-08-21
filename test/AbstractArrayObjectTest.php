<?php

namespace Laz0r\UtilTest;

use ArrayObject;
use ArrayIterator;
use Laz0r\Util\AbstractArrayObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use stdClass;

/**
 * @coversDefaultClass \Laz0r\Util\AbstractArrayObject
 */
class AbstractArrayObjectTest extends TestCase {

	public static function setupBeforeClass(): void {
		require_once __DIR__ . "/../src/AbstractArrayObject.php";
	}

	/**
	 * @covers ::getStorage
	 *
	 * @return void
	 */
	public function testGetStorageCreatesArrayObject(): void {
		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Method = $RC->getMethod("getStorage");

		$Method->setAccessible(true);
		$Result = $Method->invokeArgs($Sut, []);

		$this->assertInstanceOf(ArrayObject::class, $Result);
	}

	/**
	 * @covers ::getStorage
	 *
	 * @return void
	 */
	public function testGetStorageReturnsStorage(): void {
		$Stub = $this->createStub(ArrayObject::class);
		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");
		$Method = $RC->getMethod("getStorage");

		$Property->setAccessible(true);
		$Property->setValue($Sut, $Stub);
		$Method->setAccessible(true);
		$Result = $Method->invokeArgs($Sut, []);

		$this->assertSame($Stub, $Result);
	}

	/**
	 * @covers ::count
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return int
	 */
	public function testCountInvokesCount(): int {
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["count"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");

		$Mock->expects($this->once())
			->method("count")
			->willReturn(42);
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);

		return $Sut->count();
	}

	/**
	 * @coversNothing
	 * @depends testCountInvokesCount
	 * @param int $result
	 *
	 * @return void
	 */
	public function testCountReturnsCount(int $result): void {
		$this->assertSame(42, $result);
	}

	/**
	 * @covers ::exchangeArray
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testExchangeArrayInvokesExchangeArray(): void {
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["exchangeArray", "getArrayCopy"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");
		$array = ["imma" => "firin", "mah" => "Laz0r"];

		$Mock->expects($this->once())
			->method("exchangeArray")
			->with($this->identicalTo($array));
		$Mock->expects($this->any())
			->method("getArrayCopy")
			->willReturn([]);
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);

		$Sut->exchangeArray($array);
	}

	/**
	 * @covers ::exchangeArray
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return array
	 */
	public function testExchangeArrayInvokesGetArrayCopy(): array {
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["exchangeArray", "getArrayCopy"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");
		$array = ["imma" => "firin", "mah" => "Laz0r"];

		$Mock->expects($this->any())
			->method("exchangeArray");
		$Mock->expects($this->once())
			->method("getArrayCopy")
			->willReturn($array);
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);

		return $Sut->exchangeArray([]);
	}

	/**
	 * @coversNothing
	 * @depends testExchangeArrayInvokesGetArrayCopy
	 * @param array $result
	 *
	 * @return void
	 */
	public function testExchangeArrayResult(array $result): void {
		$this->assertSame(["imma" => "firin", "mah" => "Laz0r"], $result);
	}

	/**
	 * @covers ::getArrayCopy
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return array
	 */
	public function testGetArrayCopyInvokesGetArrayCopy(): array {
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["getArrayCopy"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");

		$Mock->expects($this->once())
			->method("getArrayCopy")
			->willReturn(["imma" => "firin", "mah" => "Laz0r"]);
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);

		return $Sut->getArrayCopy();
	}

	/**
	 * @coversNothing
	 * @depends testGetArrayCopyInvokesGetArrayCopy
	 * @param array $result
	 *
	 * @return void
	 */
	public function testGetArrayCopyResult(array $result): void {
		$this->assertSame(["imma" => "firin", "mah" => "Laz0r"], $result);
	}

	/**
	 * @covers ::getIterator
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testGetIterator(): void {
		$Stub = $this->createStub(ArrayIterator::class);
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["getIterator"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");

		$Mock->expects($this->once())
			->method("getIterator")
			->willReturn($Stub);
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);

		$Result = $Sut->getIterator();
		$this->assertSame($Stub, $Result);
	}

	/**
	 * @covers ::offsetExists
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return bool
	 */
	public function testOffsetExistsInvokesOffsetExists(): bool {
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["offsetExists"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");

		$Mock->expects($this->once())
			->method("offsetExists")
			->with($this->identicalTo("Herp Derp"))
			->willReturn(true);
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);

		return $Sut->offsetExists("Herp Derp");
	}

	/**
	 * @coversNothing
	 * @depends testOffsetExistsInvokesOffsetExists
	 * @param bool $result
	 *
	 * @return void
	 */
	public function testOffsetExistsResult(bool $result): void {
		$this->assertTrue($result);
	}

	/**
	 * @covers ::offsetGet
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testOffsetGet(): void {
		$Stub = $this->createStub(stdClass::class);
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["offsetGet"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");

		$Mock->expects($this->once())
			->method("offsetGet")
			->with($this->identicalTo("Herp Derp"))
			->willReturn($Stub);
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);

		$Result = $Sut->offsetGet("Herp Derp");
		$this->assertSame($Stub, $Result);
	}

	/**
	 * @covers ::offsetSet
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testOffsetSet(): void {
		$Stub = $this->createStub(stdClass::class);
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["offsetSet"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");

		$Mock->expects($this->once())
			->method("offsetSet")
			->with(
				$this->identicalTo("Herp Derp"),
				$this->identicalTo($Stub),
			);
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);

		$Sut->offsetSet("Herp Derp", $Stub);
	}

	/**
	 * @covers ::offsetUnset
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testOffsetUnset(): void {
		$Stub = $this->createStub(stdClass::class);
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["offsetUnset"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");

		$Mock->expects($this->once())
			->method("offsetUnset")
			->with($this->identicalTo("Herp Derp"));
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);

		$Sut->offsetUnset("Herp Derp");
	}

	/**
	 * @covers ::serialize
	 *
	 * @return string
	 */
	public function testSerialize(): string {
		$Stub = new ArrayObject();
		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");

		$Property->setAccessible(true);
		$Property->setValue($Sut, $Stub);

		$result = $Sut->serialize();
		$this->assertSame(serialize($Stub), $result);

		return $result;
	}

	/**
	 * @covers ::unserialize
	 * @depends testSerialize
	 * @param string $serialized
	 *
	 * @return void
	 */
	public function testUnserialize(string $serialized): void {
		$Stub = $this->createStub(ArrayObject::class);
		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");

		$Property->setAccessible(true);
		$Property->setValue($Sut, $Stub);

		$Sut->unserialize($serialized);
		$this->assertNotSame($Stub, $Property->getValue($Sut));
		$this->assertIsObject($Property->getValue($Sut));
	}

	/**
	 * @covers ::append
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testAppend(): void {
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["append"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");
		$Method = $RC->getMethod("append");

		$Mock->expects($this->once())
			->method("append")
			->with($this->identicalTo("Herp Derp"));
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);
		$Method->setAccessible(true);

		$Method->invokeArgs($Sut, ["Herp Derp"]);
	}

	/**
	 * @covers ::asort
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testAsort(): void {
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["asort"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");
		$Method = $RC->getMethod("asort");

		$Mock->expects($this->once())
			->method("asort")
			->with($this->identicalTo(42));
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);
		$Method->setAccessible(true);

		$Method->invokeArgs($Sut, [42]);
	}

	/**
	 * @covers ::getIteratorClass
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return string
	 */
	public function testGetIteratorClassInvokesGetIteratorClass(): string {
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["getIteratorClass"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");
		$Method = $RC->getMethod("getIteratorClass");

		$Mock->expects($this->once())
			->method("getIteratorClass")
			->willReturn(ArrayIterator::class);
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);
		$Method->setAccessible(true);

		return $Method->invokeArgs($Sut, []);
	}

	/**
	 * @coversNothing
	 * @depends testGetIteratorClassInvokesGetIteratorClass
	 * @param string $result
	 *
	 * @return void
	 */
	public function testGetIteratorClassResult(string $result): void {
		$this->assertSame(ArrayIterator::class, $result);
	}

	/**
	 * @covers ::ksort
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testKsort(): void {
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["ksort"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");
		$Method = $RC->getMethod("ksort");

		$Mock->expects($this->once())
			->method("ksort")
			->with($this->identicalTo(42));
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);
		$Method->setAccessible(true);

		$Method->invokeArgs($Sut, [42]);
	}

	/**
	 * @covers ::natcasesort
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testNatcasesort(): void {
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["natcasesort"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");
		$Method = $RC->getMethod("natcasesort");

		$Mock->expects($this->once())
			->method("natcasesort");
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);
		$Method->setAccessible(true);

		$Method->invokeArgs($Sut, []);
	}

	/**
	 * @covers ::natsort
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testNatsort(): void {
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["natsort"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");
		$Method = $RC->getMethod("natsort");

		$Mock->expects($this->once())
			->method("natsort");
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);
		$Method->setAccessible(true);

		$Method->invokeArgs($Sut, []);
	}

	/**
	 * @covers ::setIteratorClass
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testSetIteratorClass(): void {
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["setIteratorClass"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");
		$Method = $RC->getMethod("setIteratorClass");

		$Mock->expects($this->once())
			->method("setIteratorClass")
			->with($this->identicalTo(ArrayIterator::class));
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);
		$Method->setAccessible(true);

		$Method->invokeArgs($Sut, [ArrayIterator::class]);
	}

	/**
	 * @covers ::uasort
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testUasort(): void {
		$Stub = static function() {};
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["uasort"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");
		$Method = $RC->getMethod("uasort");

		$Mock->expects($this->once())
			->method("uasort")
			->with($this->identicalTo($Stub));
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);
		$Method->setAccessible(true);

		$Method->invokeArgs($Sut, [$Stub]);
	}

	/**
	 * @covers ::uksort
	 * @depends testGetStorageReturnsStorage
	 * @uses \Laz0r\Util\AbstractArrayObject::getStorage
	 *
	 * @return void
	 */
	public function testUksort(): void {
		$Stub = static function() {};
		$Mock = $this->getMockBuilder(ArrayObject::class)
			->setMethods(["uksort"])
			->getMock();

		$Sut = $this->getMockForAbstractClass(AbstractArrayObject::class);
		$RC = new ReflectionClass(AbstractArrayObject::class);
		$Property = $RC->getProperty("Storage");
		$Method = $RC->getMethod("uksort");

		$Mock->expects($this->once())
			->method("uksort")
			->with($this->identicalTo($Stub));
		$Property->setAccessible(true);
		$Property->setValue($Sut, $Mock);
		$Method->setAccessible(true);

		$Method->invokeArgs($Sut, [$Stub]);
	}

}

/* vi:set ts=4 sw=4 noet: */
