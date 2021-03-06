<?php

declare(strict_types = 1);

namespace Kucera\Monolog;

use Tracy\BlueScreen;

class BlueScreenFactoryTest extends \Kucera\Monolog\TestCase
{

	public function testBlueScreen()
	{
		$blueScreen = BlueScreenFactory::create();
		$this->assertInstanceOf(BlueScreen::class, $blueScreen);
	}

}
