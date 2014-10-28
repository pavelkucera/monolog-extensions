<?php

/**
 * Copyright (c) 2014 Pavel Kučera (http://github.com/pavelkucera)
 */

namespace Kucera\Monolog;

use Monolog\Logger;

class Factory
{

    /**
     * @param array $info
     * @return \Tracy\BlueScreen
     */
    public static function blueScreen(array $info = array())
    {
        $blueScreen = new \Tracy\BlueScreen();
        $blueScreen->info = array_merge(array(
            'PHP ' . PHP_VERSION,
            isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : NULL,
            'Tracy ' . \Tracy\Debugger::$version,
        ), $info);
        return $blueScreen;
    }

    /**
     * @param string $logDirectory
     * @param int $level
     * @param bool $bubble
     * @param \Tracy\BlueScreen $blueScreen
     * @return Handler\BlueScreenHandler
     */
    public static function blueScreenHandler($logDirectory, $level = Logger::DEBUG, $bubble = TRUE, \Tracy\BlueScreen $blueScreen = NULL)
    {
        $blueScreen = $blueScreen ?: static::blueScreen();
        return new Handler\BlueScreenHandler($blueScreen, $logDirectory, $level, $bubble);
    }

}
