<?php

namespace Dxw\WordPressSetup\Modules;

class Menu
{
	public function createAndAssignLocation(string $menuName, string $location)
	{
		$menuId = wp_create_nav_menu($menuName);
		$locations = get_theme_mod('nav_menu_locations');
		$locations[$location] = $menuId;
		set_theme_mod('nav_menu_locations', $locations);
		return $menuId;
	}

	public function addCustomLink(int $menuId, string $itemTitle, string $itemUrl, int $parentId = 0)
	{
		return wp_update_nav_menu_item($menuId, 0, [
			'menu-item-type' => 'custom',
			'menu-item-status' => 'publish',
			'menu-item-url' => $itemUrl,
			'menu-item-title' => $itemTitle,
			'menu-item-parent-id' => $parentId
		]);
	}

	public function addTaxonomyLink(int $menuId, int $termId, string $taxonomyName, int $parentId = 0)
	{
		return wp_update_nav_menu_item($menuId, 0, [
			'menu-item-type' => 'taxonomy',
			'menu-item-object' => $taxonomyName,
			'menu-item-object-id' => $termId,
			'menu-item-status' => 'publish',
			'menu-item-parent-id' => $parentId
		]);
	}
}
