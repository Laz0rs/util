<?php

namespace Laz0r\UtilTest;

use Exception;
use Laz0r\Util\CreateObjectTrait;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @coversDefaultClass \Laz0r\Util\CreateObjectTrait
 */
class CreateObjectTraitTest extends TestCase {

	public static function setupBeforeClass(): void {
		require_once __DIR__ . "/../src/CreateObjectTrait.php";
	}

	/**
	 * @covers ::createObject
	 *
	 * @return void
	 */
	public function testCreateObject(): void {
		$Sut = $this->getMockForTrait(CreateObjectTrait::class);
		$Method = (new ReflectionClass(get_class($Sut)))
			->getMethod("createObject");
		$Method->setAccessible(true);

		$Result = $Method->invokeArgs(
			$Sut,
			[Exception::class, "Herp Derp", 42],
		);

		$this->assertInstanceOf(Exception::class, $Result);
		$this->assertSame("Herp Derp", $Result->getMessage());
		$this->assertSame(42, $Result->getCode());
	}

}

/* vi:set ts=4 sw=4 noet: */
