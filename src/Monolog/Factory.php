<?php

/**
 * Copyright (c) 2014 Pavel Kučera (http://github.com/pavelkucera)
 */

namespace Kucera\Monolog;

use Kucera\Monolog\Handler\BlueScreenHandler;
use Monolog\Logger;
use Tracy\BlueScreen;
use Tracy\Debugger;

class Factory
{

	/**
	 * @param mixed[] $info
	 * @return BlueScreen
	 */
	public static function blueScreen(array $info = [])
	{
		$blueScreen = new BlueScreen();
		$blueScreen->info = array_merge([
			'PHP ' . PHP_VERSION,
			isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : NULL,
			'Tracy ' . Debugger::VERSION,
		], $info);
		return $blueScreen;
	}

	/**
	 * @param string $logDirectory
	 * @param int $level
	 * @param bool $bubble
	 * @param BlueScreen $blueScreen
	 * @return BlueScreenHandler
	 */
	public static function blueScreenHandler($logDirectory, $level = Logger::DEBUG, $bubble = TRUE, BlueScreen $blueScreen = NULL)
	{
		$blueScreen = $blueScreen !== NULL ? $blueScreen : static::blueScreen();
		return new BlueScreenHandler($blueScreen, $logDirectory, $level, $bubble);
	}

}
