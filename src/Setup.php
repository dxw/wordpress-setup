<?php

namespace Dxw\WordPressSetup;

class Setup
{
    public $post;
    public $menu;

    public function __construct($post, $menu)
    {
        $this->post = $post;
        $this->menu = $menu;
    }
}
