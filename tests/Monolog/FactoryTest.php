<?php

namespace Kucera\Monolog;

use Kucera\Monolog\Handler\BlueScreenHandler;
use Tracy\BlueScreen;

class BlueScreenFactoryTest extends \Kucera\Monolog\TestCase
{

	public function testBlueScreen()
	{
		$blueScreen = Factory::blueScreen();
		$this->assertInstanceOf(BlueScreen::class, $blueScreen);
	}

	public function testBlueScreenHandler()
	{
		$handler = Factory::blueScreenHandler(__DIR__);
		$this->assertInstanceOf(BlueScreenHandler::class, $handler);
	}

}
