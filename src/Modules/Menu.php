<?php

namespace Dxw\WordPressSetup\Modules;

class Menu
{
    public function createAndAssignLocation($menuName, $location)
    {
        $menuId = wp_create_nav_menu($menuName);
        $locations = get_theme_mod('nav_menu_locations');
        $locations[$location] = $menuId;
        set_theme_mod('nav_menu_locations', $locations);
        return $menuId;
    }
}
