<?php

namespace Dxw\WordPressSetup;

class Factory
{
    public static function create()
    {
        $faker = \Faker\Factory::create();
        $post = new Modules\Post($faker);
        $setup = new Setup($post);
        return $setup;
    }
}
