<?php

namespace Laz0r\UtilTest;

use Laz0r\Util\AbstractReader;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use SplFileObject;

/**
 * @coversDefaultClass \Laz0r\Util\AbstractReader
 */
class AbstractReaderTest extends TestCase {

	public static function setupBeforeClass(): void {
		require_once __DIR__ . "/../src/Exception/ExceptionInterface.php";
		require_once __DIR__ . "/../src/Exception/LogicException.php";
		require_once __DIR__ . "/../src/AbstractConstructOnce.php";
		require_once __DIR__ . "/../src/AbstractReader.php";
	}

	/**
	 * @covers ::__construct
	 * @uses \Laz0r\Util\AbstractConstructOnce
	 *
	 * @return void
	 */
	public function testConstructor(): void {
		$Sut = $this->getMockBuilder(AbstractReader::class)
			->disableOriginalConstructor()
			->getMock();
		$Property = (new ReflectionClass(AbstractReader::class))
			->getProperty("filename");

		$Sut->__construct("imma/firin/mah/Laz0r");
		$Property->setAccessible(true);
		$this->assertSame("imma/firin/mah/Laz0r", $Property->getValue($Sut));
	}

	/**
	 * @covers ::getFile
	 *
	 * @return void
	 */
	public function testGetFileHavingInstance(): void {
		$Stub = new SplFileObject(__FILE__, "r");
		$Sut = new class() extends AbstractReader {

			public function __construct() {
			}

		};
		$RC = new ReflectionClass(AbstractReader::class);
		$Method = $RC->getMethod("getFile");
		$Property = $RC->getProperty("File");

		$Property->setAccessible(true);
		$Property->setValue($Sut, $Stub);
		$Method->setAccessible(true);

		$Result = $Method->invokeArgs($Sut, []);

		$this->assertSame($Stub, $Result);
	}

	/**
	 * @covers ::createFile
	 *
	 * @return void
	 */
	public function testCreateFile(): void {
		$Sut = new class() extends AbstractReader {

			public function __construct() {
			}

		};
		$Method = (new ReflectionClass(AbstractReader::class))
			->getMethod("createFile");

		$Method->setAccessible(true);
		$Result = $Method->invokeArgs($Sut, [__FILE__]);

		$this->assertSame(basename(__FILE__), $Result->getBasename());
	}

	/**
	 * @covers ::getFilename
	 *
	 * @return void
	 */
	public function testGetFilename(): void {
		$Sut = new class() extends AbstractReader {

			public function __construct() {
			}

		};
		$RC = new ReflectionClass(AbstractReader::class);
		$Method = $RC->getMethod("getFilename");
		$Property = $RC->getProperty("filename");

		$Property->setAccessible(true);
		$Property->setValue($Sut, "/over/9000");
		$Method->setAccessible(true);

		$result = $Method->invokeArgs($Sut, []);

		$this->assertSame("/over/9000", $result);
	}

}

/* vi:set ts=4 sw=4 noet: */
