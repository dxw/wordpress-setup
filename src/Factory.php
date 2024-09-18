<?php

namespace Dxw\WordPressSetup;

class Factory
{
	public static function create()
	{
		$faker = \Faker\Factory::create();
		$setup = new Setup([
			'post' => new Modules\Post($faker),
			'menu' => new Modules\Menu(),
			'media' => new Modules\Media(),
			'plugin' => new Modules\Plugin()
		]);
		return $setup;
	}
}
