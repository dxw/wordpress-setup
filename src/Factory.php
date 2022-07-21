<?php

namespace Dxw\WordPressSetup;

class Factory
{
    public static function create()
    {
        $faker = \Faker\Factory::create();
        $post = new Modules\Post($faker);
        $menu = new Modules\Menu();
        $setup = new Setup($post, $menu);
        return $setup;
    }
}
