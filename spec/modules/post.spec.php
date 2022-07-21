<?php

use Kahlan\Plugin\Double;

describe(\Dxw\WordPressSetup\Modules\Post::class, function () {
    beforeEach(function () {
        $this->faker = Double::instance();
        $this->post = new \Dxw\WordPressSetup\Modules\Post($this->faker);
    });

    describe('->create()', function () {
        context('no args passed', function () {
            it('publishes a post with fake content', function () {
                allow($this->faker)->toReceive('sentence')->andReturn('A title sentence.');
                allow($this->faker)->toReceive('paragraph')->andReturn('The first paragraph.', 'The second paragraph.', 'The third paragraph.');
                allow('wp_parse_args')->toBeCalled()->andRun(function ($args, $defaults) {
                    return $defaults;
                });
                allow('wp_insert_post')->toBeCalled();
                expect('wp_insert_post')->toBeCalled()->once()->with([
                    'post_status' => 'publish',
                    'post_title' => 'A title sentence',
                    'post_content' => '<!-- wp:paragraph --><p>The first paragraph.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>The second paragraph.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>The third paragraph.</p><!-- /wp:paragraph -->',
                    'post_type' => 'post'
                ]);
                $this->post->create();
            });
        });

        context('args passed', function () {
            it('parses the args and overwrites the defaults', function () {
                allow($this->faker)->toReceive('sentence')->andReturn('A title sentence.');
                allow($this->faker)->toReceive('paragraph')->andReturn('The first paragraph.', 'The second paragraph.', 'The third paragraph.');
                allow('wp_parse_args')->toBeCalled()->andRun(function ($args, $defaults) {
                    return [
                    'post_status' => 'draft',
                    'post_title' => 'A title sentence',
                    'post_content' => '<!-- wp:paragraph --><p>The first paragraph.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>The second paragraph.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>The third paragraph.</p><!-- /wp:paragraph -->',
                    'post_type' => 'post'
                ];
                });
                allow('wp_insert_post')->toBeCalled();
                expect('wp_insert_post')->toBeCalled()->once()->with([
                    'post_status' => 'draft',
                    'post_title' => 'A title sentence',
                    'post_content' => '<!-- wp:paragraph --><p>The first paragraph.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>The second paragraph.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>The third paragraph.</p><!-- /wp:paragraph -->',
                    'post_type' => 'post'
                ]);
                $this->post->create([
                    'post_status' => 'draft'
                ]);
            });
        });
    });
});
