<?php

namespace Laz0r\Util;

use SplFileObject;

abstract class AbstractReader extends AbstractConstructOnce {

	private string $filename;

	private ?SplFileObject $File = null;

	/**
	 * @param string $filename
	 */
	public function __construct(string $filename) {
		parent::__construct();

		$this->filename = $filename;
	}

	/**
	 * @return \SplFileObject
	 */
	protected function getFile(): SplFileObject {
		$this->File ??= $this->createFile($this->getFilename());

		return $this->File;
	}

	/**
	 * @param string $filename
	 *
	 * @return \SplFileObject
	 */
	private function createFile(string $filename): SplFileObject {
		return new SplFileObject($filename, "r", true);
	}

	/**
	 * @return string
	 */
	private function getFilename(): string {
		return $this->filename;
	}

}

/* vi:set ts=4 sw=4 noet: */
