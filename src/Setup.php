<?php

namespace Dxw\WordPressSetup;

class Setup
{
    public $post;

    public function __construct($post)
    {
        $this->post = $post;
    }
}
