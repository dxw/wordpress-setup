<?php

describe(\Dxw\WordPressSetup\Modules\Menu::class, function () {
    beforeEach(function () {
        $this->menu = new \Dxw\WordPressSetup\Modules\Menu();
    });

    describe('->createAndAssignLocation()', function () {
        it('creates the menu, assigns its location and returns the menu Id', function () {
            $menuName = 'My new menu';
            $location = 'header';
            $menuId = 123;
            allow('wp_create_nav_menu')->toBeCalled()->andReturn($menuId);
            expect('wp_create_nav_menu')->toBeCalled()->once()->with('My new menu');
            allow('get_theme_mod')->toBeCalled()->andReturn([
                'header' => 456,
                'footer' => 789
            ]);
            allow('set_theme_mod')->toBeCalled();
            expect('set_theme_mod')->toBeCalled()->once()->with('nav_menu_locations', [
                'header' => 123,
                'footer' => 789
            ]);

            $result = $this->menu->createAndAssignLocation($menuName, $location);

            expect($result)->toEqual($menuId);
        });
    });
});
