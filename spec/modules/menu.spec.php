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

    describe('->addCustomLink()', function () {
        context('no parent Id is given', function () {
            it('updates the nav menu with a new custom link item at the top level, then returns the menu item id', function () {
                $menuId = 123;
                $itemTitle = 'My new link';
                $itemUrl = 'https://dxw.com';
                allow('wp_update_nav_menu_item')->toBeCalled()->andReturn(789);
                expect('wp_update_nav_menu_item')->toBeCalled()->once()->with(
                    123,
                    0,
                    [
                        'menu-item-type' => 'custom',
                        'menu-item-status' => 'publish',
                        'menu-item-url' => $itemUrl,
                        'menu-item-title' => $itemTitle,
                        'menu-item-parent-id' => 0
                    ]
                );
    
                $result = $this->menu->addCustomLink($menuId, $itemTitle, $itemUrl);
    
                expect($result)->toEqual(789);
            });
        });

        context('a parent Id is given', function () {
            it('updates the nav menu with a new custom link item under the specified parent, then returns the menu item id', function () {
                $menuId = 123;
                $itemTitle = 'My new link';
                $itemUrl = 'https://dxw.com';
                $parentId = 456;
                allow('wp_update_nav_menu_item')->toBeCalled()->andReturn(789);
                expect('wp_update_nav_menu_item')->toBeCalled()->once()->with(
                    123,
                    0,
                    [
                        'menu-item-type' => 'custom',
                        'menu-item-status' => 'publish',
                        'menu-item-url' => $itemUrl,
                        'menu-item-title' => $itemTitle,
                        'menu-item-parent-id' => 456
                    ]
                );
    
                $result = $this->menu->addCustomLink($menuId, $itemTitle, $itemUrl, $parentId);
    
                expect($result)->toEqual(789);
            });
        });
    });

    describe('->addTaxonomyLink()', function () {
        context('no parent Id is provided', function () {
            it('adds a top-level menu item and returns the menu item Id', function () {
                $menuId = 123;
                $termId = 456;
                $taxonomyName = 'category';
                allow('wp_update_nav_menu_item')->toBeCalled()->andReturn(789);
                expect('wp_update_nav_menu_item')->toBeCalled()->once()->with($menuId, 0, [
                    'menu-item-type' => 'taxonomy',
                    'menu-item-object' => $taxonomyName,
                    'menu-item-object-id' => $termId,
                    'menu-item-status' => 'publish',
                    'menu-item-parent-id' => 0
                ]);

                $result = $this->menu->addTaxonomyLink($menuId, $termId, $taxonomyName);

                expect($result)->toEqual(789);
            });
        });

        context('a parent Id is provided', function () {
            it('adds a menu item with that Id as the parent and returns the menu item Id', function () {
                $menuId = 123;
                $termId = 456;
                $parentId = 333;
                $taxonomyName = 'category';
                allow('wp_update_nav_menu_item')->toBeCalled()->andReturn(789);
                expect('wp_update_nav_menu_item')->toBeCalled()->once()->with($menuId, 0, [
                    'menu-item-type' => 'taxonomy',
                    'menu-item-object' => $taxonomyName,
                    'menu-item-object-id' => $termId,
                    'menu-item-status' => 'publish',
                    'menu-item-parent-id' => $parentId
                ]);

                $result = $this->menu->addTaxonomyLink($menuId, $termId, $taxonomyName, $parentId);

                expect($result)->toEqual(789);
            });
        });
    });
});
