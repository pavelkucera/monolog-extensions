<?php

/**
 * Copyright (c) 2014 Pavel Kučera (http://github.com/pavelkucera)
 */

declare(strict_types = 1);

namespace Kucera\Monolog;

use Tracy\BlueScreen;
use Tracy\Debugger;

class BlueScreenFactory
{

	/**
	 * @param mixed[] $info
	 * @return BlueScreen
	 */
	public static function create(array $info = []): BlueScreen
	{
		$blueScreen = new BlueScreen();
		$blueScreen->info = array_merge([
			'PHP ' . PHP_VERSION,
			isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : NULL,
			'Tracy ' . Debugger::VERSION,
		], $info);
		return $blueScreen;
	}

}
