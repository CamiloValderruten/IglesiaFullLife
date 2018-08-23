<?php
/**
 * Template part for displaying posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy
 */

$params = $theme->get('post', []);

if (!is_single()) {
    $params->merge($theme->get('blog', []));
}

$attrs_container = [];

// Image
$attrs_image['class'][] = $params['image_align'] == 'top' ? 'uk-margin-large-bottom' : 'uk-margin-medium-bottom';

// Header
$attrs_header['class'][] = 'uk-margin-medium-bottom';
$attrs_header['class'][] = $params['content_width'] ? 'uk-container uk-container-small' : '';
$attrs_header['class'][] = $params['header_align'] ? 'uk-text-center' : '';

// Container
if ($params['content_width']) {
    $attrs_container['class'][] = 'uk-container uk-container-small';
}

// Content
$attrs_content['class'][] = $params['content_align'] ? 'uk-text-center' : '';
$attrs_content['class'][] = $params['content_dropcap'] ? 'uk-dropcap' : '';

// Tags
$attrs_tags['class'][] = $params['header_align'] ? 'uk-text-center' : '';

// Button
$attrs_button['class'][] = "uk-button uk-button-{$params['button_style']}";
$attrs_button_container['class'][] = $params['header_align'] ? 'uk-text-center' : '';
$attrs_button_container['class'][] = 'uk-margin-medium';

/*
 * Image template
 */
$image = function ($attr) {
?>

<?php if ($thumbnail = get_the_post_thumbnail('', 'post-thumbnail', ['property' => 'url'])) : ?>
<div<?= get_attrs($attr) ?> property="image" typeof="ImageObject">
    <?php if (is_single()) : ?>
    <?= $thumbnail ?>
    <?php else : ?>
    <a href="<?php the_permalink() ?>"><?= $thumbnail ?></a>
    <?php endif ?>
</div>
<?php endif ?>

<?php
};

/*
 * Meta template
 */
$meta = function () use ($params) {

    $date = $params['date'] ? '<span>'.get_post_date().'</span>' : '';
    $author = $params['author'] ? get_post_author() : '';
    $category = $params['categories'] ? get_the_category_list(__(', ')) : '';
    $comments = !post_password_required() && (comments_open() || get_comments_number());

    if ($date || $author || $category || $comments) {

        switch ($params['meta_style']) {

            case 'list':

                $attrs_header['class'][] = $params['header_align'] ? 'uk-text-center' : '';

                ?>
                <ul class="uk-subnav uk-subnav-divider<?= $params['header_align'] ? ' uk-flex-center' : '' ?>">
                    <?php foreach (array_filter([$date, $author]) as $part) : ?>
                    <li><?= $part ?></li>
                    <?php endforeach ?>

                    <?php if ($category && count(wp_get_post_categories()) > 1) : ?>
                    <li><span><?= $category ?></span></li>
                    <?php elseif($category) : ?>
                    <li><?= $category ?></li>
                    <?php endif ?>

                    <?php if ($comments) : ?>
                    <li><?php comments_popup_link(__('0 Comments', 'yootheme'), __('1 Comment', 'yootheme'), __('% Comments', 'yootheme')) ?></li>
                    <?php endif ?>
                </ul>
                <?php
                break;

            default: // sentence

                ?>
                <p class="uk-article-meta">
                <?php

                if ($author && $date) {
                    printf(__('Written by %s on %s.', 'yootheme'), get_post_author(), get_post_date());
                } elseif ($author) {
                    printf(__('Written by %s.', 'yootheme'), get_post_author());
                } elseif ($date) {
                    printf(__('Written on %s.', 'yootheme'), get_post_date());
                }

                ?>
                <?php

                if ($category && $categories = get_the_category_list(__(', '))) {
                    printf(__('Posted in %1$s.', 'yootheme'), $categories);
                }

                ?>
                <?php

                if ($comments) {
                    comments_popup_link(__('Leave a Comment'), __('1 Comment', 'yootheme'), __('% Comments', 'yootheme'));
                }

                ?>
                </p>
                <?php
        }

    }

};

?>

<article id="post-<?php the_ID() ?>" <?php post_class('uk-article') ?> typeof="Article">

    <meta property="name" content="<?= esc_html(get_the_title()) ?>">
    <meta property="author" typeof="Person" content="<?= esc_html(get_the_author()) ?>">
    <meta property="dateModified" content="<?= get_the_modified_date('c') ?>">
    <meta class="uk-margin-remove-adjacent" property="datePublished" content="<?= get_the_date('c') ?>">

    <?php if ($params['image_align'] == 'top') : ?>
    <?= $image($attrs_image) ?>
    <?php endif ?>

    <div<?= get_attrs($attrs_header) ?>>

        <?php if ($params['meta_align'] == 'top') : ?>
        <?= $meta() ?>
        <?php endif ?>

        <?php
            if (is_single()) {
                the_title('<h1 class="uk-article-title uk-margin-remove-top">', '</h1>');
            } else {
                the_title('<h2 class="uk-article-title uk-margin-remove-top"><a class="uk-link-reset" href="' . esc_url(get_permalink()) . '">', '</a></h2>');
            }
        ?>

        <?php if ($params['meta_align'] == 'bottom') : ?>
        <?= $meta() ?>
        <?php endif ?>

    </div>

    <?php if ($params['image_align'] == 'between') : ?>
    <?= $image($attrs_image) ?>
    <?php endif ?>

    <?php if ($attrs_container) : ?>
    <div<?= get_attrs($attrs_container) ?>>
    <?php endif ?>

    <div<?= get_attrs($attrs_content) ?> property="text"><?php the_content('') ?></div>

    <?php if ($params['tags'] && $tags = get_the_tag_list('', __(', '))) : ?>
    <p<?= get_attrs($attrs_tags) ?>><?php printf(__('Tags: %1$s', 'yootheme'), $tags) ?></p>
    <?php endif ?>

    <?php if (!is_single() and $readmore = get_readmore()) : ?>
    <p<?= get_attrs($attrs_button_container) ?>>
        <a<?= get_attrs($attrs_button) ?> href="<?= get_permalink() ?>"><?= $readmore ?></a>
    </p>
    <?php endif ?>

    <?php if (is_single()) {
        wp_link_pages(['before' => '<div class="uk-margin-medium">' . __('Pages:') . '<ul class="uk-pagination">', 'after'  => '</ul></div>']);
    } ?>

    <?php if ($edit = get_edit_post_link()) : ?>
    <p>
        <a href="<?= esc_url($edit) ?>"><?= sprintf(__('%1$s Edit', 'yootheme'), '<span uk-icon="icon: pencil"></span>') ?></a>
    </p>
    <?php endif ?>

    <?php if (is_single() && $params['navigation']) : ?>
    <ul class="uk-pagination uk-margin-medium">
        <?php if ($prev = get_previous_post_link('%link', sprintf(__('%1$s Previous', 'yootheme'), '<span uk-pagination-previous></span>'))) : ?>
        <li><?= $prev ?></li>
        <?php endif ?>
        <?php if ($next = get_next_post_link('%link', sprintf(__('Next %1$s', 'yootheme'), '<span uk-pagination-next></span>'))) : ?>
        <li class="uk-margin-auto-left"><?= $next ?></li>
        <?php endif ?>
    </ul>
    <?php endif ?>

    <?php if (is_single() && get_the_author_meta('description')) : ?>
    <hr class="uk-margin-medium-top">
    <div class="uk-grid-medium" uk-grid>
        <div class="uk-width-auto@m">
            <?= get_avatar(get_the_author_meta('user_email')) ?>
        </div>
        <div class="uk-width-expand@m">
            <h4 class="uk-margin-small-bottom"><?php the_author() ?></h4>
            <div><?php the_author_meta('description') ?></div>
        </div>
    </div>
    <hr>
    <?php endif ?>

    <?php if ($attrs_container) : ?>
    </div>
    <?php endif ?>

</article>
