<?php

/**
 * Copyright (c) 2014 Pavel Kučera (http://github.com/pavelkucera)
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 */

declare(strict_types = 1);

namespace Kucera\Monolog;

use DateTimeInterface;
use DirectoryIterator;
use Monolog\Logger;
use Tracy\BlueScreen;

class BlueScreenHandler extends \Monolog\Handler\AbstractProcessingHandler
{

	/** @var BlueScreen */
	private $blueScreen;

	/** @var string */
	private $logDirectory;

	public function __construct(BlueScreen $blueScreen, string $logDirectory, int $level = Logger::DEBUG, bool $bubble = TRUE)
	{
		parent::__construct($level, $bubble);

		$this->blueScreen = $blueScreen;
		$this->logDirectory = $logDirectory;
	}

	/**
	 * @param mixed[] $record
	 */
	protected function write(array $record)
	{
		if (!isset($record['context']['exception']) || !$record['context']['exception'] instanceof \Throwable) {
			return;
		}

		if (!is_dir($this->logDirectory)) {
			throw new \Kucera\Monolog\LogDirectoryIsNotDirectoryException($this->logDirectory);
		}

		$exception = $record['context']['exception'];
		$filename = $this->getExceptionFilename($record['datetime'], $exception);

		$this->blueScreen->renderToFile(
			$exception,
			sprintf('%s/%s', $this->logDirectory, $filename)
		);
	}

	private function getExceptionFilename(DateTimeInterface $recordedTime, \Throwable $exception): string
	{
		$datetime = $recordedTime->format('Y-m-d-H-i-s');
		$hash = $this->getExceptionHash($exception);

		$filename = sprintf('exception--%s--%s.html', $datetime, $hash);

		foreach (new DirectoryIterator($this->logDirectory) as $entry) {
			// Exception already logged
			if (strpos($entry->getFilename(), $hash) !== FALSE) {
				return $entry->getFilename();
			}
		}

		return $filename;
	}

	public function getExceptionHash(\Throwable $exception): string
	{
		$data = [];
		while ($exception) {
			$data[] = [
				$exception->getMessage(),
				$exception->getCode(),
				$exception->getFile(),
				$exception->getLine(),
				array_map(function ($item) {
					unset($item['args']);
					return $item;
				}, $exception->getTrace()),
			];
			$exception = $exception->getPrevious();
		}

		return substr(md5(serialize($data)), 0, 10);
	}

	public function getLogDirectory(): string
	{
		return $this->logDirectory;
	}

}
