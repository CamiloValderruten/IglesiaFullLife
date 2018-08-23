<?php
/**
 * The template for displaying all pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 */

get_header();

if ($theme->get('builder')) :

    echo get_section('builder');

elseif (have_posts()) :

    while (have_posts()) : the_post();

        get_template_part('templates/post/content', 'page');

        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;

    endwhile;

endif;

get_footer();
