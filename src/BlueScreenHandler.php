<?php

/**
 * Copyright (c) 2014 Pavel Kučera (http://github.com/pavelkucera)
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 */

declare(strict_types = 1);

namespace Kucera\Monolog;

use DirectoryIterator;
use Monolog\Logger;
use Tracy\BlueScreen;

class BlueScreenHandler extends \Monolog\Handler\AbstractProcessingHandler
{

	/** @var BlueScreen */
	private $blueScreen;

	/** @var string */
	private $logDirectory;

	/**
	 * @param BlueScreen $blueScreen
	 * @param string $logDirectory
	 * @param int $level
	 * @param bool $bubble
	 */
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
		if (!isset($record['context']['exception']) || !$record['context']['exception'] instanceof \Exception) {
			return;
		}

		if (!is_dir($this->logDirectory)) {
			throw new \Kucera\Monolog\LogDirectoryIsNotDirectoryException($this->logDirectory);
		}

		$exception = $record['context']['exception'];

		$datetime = @$record['datetime']->format('Y-m-d-H-i-s');
		$hash = $this->getExceptionHash($exception);
		$filename = sprintf('exception-%s-%s.html', $datetime, $hash);

		$save = TRUE;
		foreach (new DirectoryIterator($this->logDirectory) as $entry) {
			// Exception already logged
			if (strpos((string) $entry, $hash) !== FALSE) {
				$filename = $entry;
				$save = FALSE;
				break;
			}
		}

		if ($save === TRUE) {
			$this->blueScreen->renderToFile(
				$exception,
				sprintf('%s/%s', $this->logDirectory, $filename)
			);
		}
	}

	/**
	 * @param \Exception $exception
	 * @return string
	 */
	public function getExceptionHash(\Exception $exception): string
	{
		return md5(preg_replace('~(Resource id #)\d+~', '$1', $exception));
	}

	/**
	 * @return string
	 */
	public function getLogDirectory(): string
	{
		return $this->logDirectory;
	}

}
