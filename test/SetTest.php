<?php

namespace Laz0r\UtilTest;

use Laz0r\Util\Set;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @coversDefaultClass \Laz0r\Util\Set
 */
class SetTest extends TestCase {

	public static function setupBeforeClass(): void {
		require_once __DIR__ . "/../src/SetInterface.php";
		require_once __DIR__ . "/../src/Set.php";
	}

	/**
	 * @covers ::add
	 *
	 * @return bool
	 */
	public function testAddExisting(): bool {
		$Stub = (object)[];
		$Sut = $this->getMockBuilder(Set::class)
			->disableOriginalConstructor()
			->setMethods(["contains", "push"])
			->getMock();

		$Sut->expects($this->never())
			->method("push");
		$Sut->expects($this->once())
			->method("contains")
			->with($this->identicalTo($Stub))
			->willReturn(true);

		return $Sut->add($Stub);
	}

	/**
	 * @coversNothing
	 * @depends testAddExisting
	 * @param bool $result
	 *
	 * @return void
	 */
	public function testAddReturnsFalse(bool $result): void {
		$this->assertFalse($result);
	}

	/**
	 * @covers ::add
	 *
	 * @return bool
	 */
	public function testAddNew(): bool {
		$Stub = (object)[];
		$Sut = $this->getMockBuilder(Set::class)
			->disableOriginalConstructor()
			->setMethods(["contains", "push"])
			->getMock();

		$Sut->expects($this->once())
			->method("contains")
			->with($this->identicalTo($Stub))
			->willReturn(false);
		$Sut->expects($this->once())
			->method("push")
			->with($this->identicalTo($Stub));

		return $Sut->add($Stub);
	}

	/**
	 * @coversNothing
	 * @depends testAddNew
	 * @param bool $result
	 *
	 * @return void
	 */
	public function testAddReturnsTrue(bool $result): void {
		$this->assertTrue($result);
	}

	/**
	 * @covers ::clear
	 *
	 * @return void
	 */
	public function testClear(): void {
		$Sut = new Set();
		$Property = (new ReflectionClass(Set::class))
			->getProperty("items");

		$Property->setAccessible(true);
		$Property->setValue($Sut, range(13, 37));
		$Sut->clear();

		$this->assertSame([], $Property->getValue($Sut));
	}

	/**
	 * @covers ::contains
	 *
	 * @return void
	 */
	public function testContainsExisting(): void {
		$Stub = (object)[];
		$Sut = new Set();
		$Property = (new ReflectionClass(Set::class))
			->getProperty("items");

		$Property->setAccessible(true);
		$Property->setValue($Sut, [$Stub]);

		$result = $Sut->contains($Stub);
		$this->assertTrue($result);
	}

	/**
	 * @covers ::contains
	 *
	 * @return void
	 */
	public function testContainsStrictness(): void {
		$Sut = new Set();
		$Property = (new ReflectionClass(Set::class))
			->getProperty("items");

		$Property->setAccessible(true);
		$Property->setValue($Sut, [42]);

		$result = $Sut->contains("42");
		$this->assertFalse($result);
	}

	/**
	 * @covers ::remove
	 *
	 * @return void
	 */
	public function testRemove(): void {
		$Sut = new Set();
		$Property = (new ReflectionClass(Set::class))
			->getProperty("items");

		$Property->setAccessible(true);
		$Property->setValue($Sut, [42, "42"]);

		$Sut->remove("42");

		$this->assertSame([42], $Property->getValue($Sut));
	}

	/**
	 * @covers ::toArray
	 *
	 * @return void
	 */
	public function testToArray(): void {
		$items = [21, 12];
		$Sut = new Set();
		$Property = (new ReflectionClass(Set::class))
			->getProperty("items");

		$Property->setAccessible(true);
		$Property->setValue($Sut, $items);

		$result = $Sut->toArray();

		$this->assertSame($items, $result);
	}

	/**
	 * @covers ::push
	 *
	 * @return void
	 */
	public function testPush(): void {
		$Stub = (object)[];
		$Sut = new Set();
		$RC = new ReflectionClass(Set::class);
		$Method = $RC->getMethod("push");
		$Property = $RC->getProperty("items");

		$Property->setAccessible(true);
		$Property->setValue($Sut, [42]);
		$Method->setAccessible(true);
		$Method->invokeArgs($Sut, [$Stub]);

		$this->assertSame([42, $Stub], $Property->getValue($Sut));
	}

}

/* vi:set ts=4 sw=4 noet: */
