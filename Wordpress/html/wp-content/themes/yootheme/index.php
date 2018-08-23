<?php
/**
 * The main template file.
 *
 * The most generic template file in the WordPress file hierarchy.
 * Used if WordPress cannot find any other matching template file.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy
 */

get_header();

?>

<?php if (have_posts()) :

    $columns = get_post_columns($theme->get('blog.column', 1), $theme->get('blog.column_order'));

    $attrs = [];
    $attrs['class'][] = 'uk-child-width-1-' . count($columns) . '@m';
    $attrs['class'][] = $theme->get('blog.column_gutter') ? 'uk-grid-large' : '';
    $attrs['class'][] = $theme->get('blog.column_divider') ? 'uk-grid-divider' : '';
    $attrs['uk-grid'] = true;

    ?>

    <div<?= get_attrs($attrs) ?>>
    <?php foreach ($columns as $column) : ?>
        <div>
        <?php foreach ($column as $post) {
            setup_postdata($GLOBALS['post'] = $post);
            get_template_part('templates/post/content', get_post_format());
        } ?>
        </div>
    <?php endforeach ?>
    </div>

    <?php

    get_template_part('templates/pagination');

else :

    get_template_part('templates/post/content', 'none');

endif;

get_footer();