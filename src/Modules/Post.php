<?php

namespace Dxw\WordPressSetup\Modules;

class Post
{
    private $faker;

    public function __construct($faker)
    {
        $this->faker = $faker;
    }

    public function create(array $args = [])
    {
        $defaults = [
            'post_status' => 'publish',
            'post_title' => $this->title(),
            'post_content' => $this->content(),
            'post_type' => 'post'
        ];
        return wp_insert_post(wp_parse_args($args, $defaults));
    }

    private function title(int $words = 3)
    {
        $sentence = $this->faker->sentence($words);
        return substr($sentence, 0, strlen($sentence) - 1);
    }

    private function content(int $paragraphs = 3)
    {
        $content = '';
        for ($i=0; $i<$paragraphs; $i++) {
            $content .= "<!-- wp:paragraph --><p>" . $this->faker->paragraph() . "</p><!-- /wp:paragraph -->";
        }
        return $content;
    }
}
