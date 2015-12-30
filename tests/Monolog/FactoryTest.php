<?php

namespace Kucera\Monolog;

class BlueScreenFactoryTest extends \Kucera\Monolog\TestCase
{

	public function testBlueScreen()
	{
		$blueScreen = Factory::blueScreen();
		$this->assertInstanceOf('Tracy\BlueScreen', $blueScreen);
	}

	public function testBlueScreenHandler()
	{
		$handler = Factory::blueScreenHandler(__DIR__);
		$this->assertInstanceOf('Kucera\Monolog\Handler\BlueScreenHandler', $handler);
	}

}
