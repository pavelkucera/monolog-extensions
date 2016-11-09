<?php

declare(strict_types = 1);

namespace Kucera\Monolog;

class LogDirectoryIsNotDirectoryException extends \RuntimeException implements \Kucera\Monolog\Exception
{

	/** @var string */
	private $logDirectory;

	public function __construct(string $logDirectory)
	{
		parent::__construct(sprintf(
			'Path "%s" is not a directory.',
			$logDirectory
		));
		$this->logDirectory = $logDirectory;
	}

	public function getLogDirectory(): string
	{
		return $this->logDirectory;
	}

}
