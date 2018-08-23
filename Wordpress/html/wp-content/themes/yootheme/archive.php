<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#category
 */

get_header();

?>

<?php if (have_posts()) :

    // Header
    $title = get_the_archive_title();
    $description = get_the_archive_description();

    $attrs_title = [];
    $attrs_description = [];

    if ($description) {
        $attrs_description['class'][] = 'uk-margin-medium-bottom';
    } else {
        $attrs_title['class'][] = 'uk-margin-medium-bottom';
    }

    if ($theme->get('post.header_align')) {
        $attrs_title['class'][] = 'uk-text-center';
        $attrs_description['class'][] = 'uk-text-center';
    }

    // Grid
    $columns = get_post_columns($theme->get('blog.column', 1), $theme->get('blog.column_order'));

    $attrs['class'][] = 'uk-child-width-1-' . count($columns) . '@m';
    $attrs['class'][] = $theme->get('blog.column_gutter') ? 'uk-grid-large' : '';
    $attrs['class'][] = $theme->get('blog.column_divider') ? 'uk-grid-divider' : '';
    $attrs['uk-grid'] = true;

    ?>

    <?php if (!is_category() || $theme->get('blog.category_title')) : ?>

        <h3<?= get_attrs($attrs_title) ?>><?= $title ?></h3>

        <?php if ($description) : ?>
        <div<?= get_attrs($attrs_description) ?>><?= $description ?></div>
        <?php endif ?>

    <?php endif ?>

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

    get_template_part('templates/pagination', 'archive');

else :

    get_template_part('templates/post/content', 'none');

endif;

get_footer();
