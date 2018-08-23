<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 */

get_header();

?>

<?php if (have_posts()) :

    $attrs_title['class'][] = 'uk-margin-medium-bottom';
    $attrs_title['class'][] = $theme->get('post.header_align') ? 'uk-text-center' : '';

    ?>

    <h3<?= get_attrs($attrs_title) ?>><?php printf(__( 'Search Results for &#8220;%s&#8221;' ), '<span>' . get_search_query() . '</span>') ?></h3>

    <?php while (have_posts()) : the_post();

        get_template_part('templates/post/content', 'search');

    endwhile;

    get_template_part('templates/pagination', 'search');

else :

    get_template_part('templates/post/content', 'none');

endif;

get_footer();
