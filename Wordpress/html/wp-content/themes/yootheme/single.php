<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

get_header();

// Container
$attrs_container = [];

if ($theme->get('post.content_width')) {
    $attrs_container['class'][] = 'uk-container uk-container-small';
}

if (have_posts()) :

    while (have_posts()) : the_post();

        get_template_part('templates/post/content', get_post_format());

        if ($attrs_container) :
            printf('<div%s>', get_attrs($attrs_container));
        endif;

        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;

        if ($attrs_container) :
            echo '</div>';
        endif;

    endwhile;

endif;

get_footer();
