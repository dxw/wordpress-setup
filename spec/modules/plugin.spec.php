<?php

use Kahlan\Plugin\Double;

describe(\Dxw\WordPressSetup\Modules\Plugin::class, function () {
	beforeEach(function () {
		$this->plugin = new \Dxw\WordPressSetup\Modules\Plugin();
	});

	describe('->activate()', function () {
		it('calls WP CLI plugin activate with the slug', function () {
			allow('WP_CLI')->toBeOK();
			allow('WP_CLI')->toReceive('::runcommand');
			expect('WP_CLI')->toReceive('::runcommand')->once()->with('plugin activate foo');

			$this->plugin->activate('foo');
		});
	});
});
