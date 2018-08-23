<?php

use YOOtheme\Module\ConfigLoader;
use YOOtheme\Theme;
use YOOtheme\Theme\Wordpress\MenuWalker;

/**
 * Boostrap theme and configuration.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions
 */
add_action('after_setup_theme', function () {

    global $theme;

    $app = require __DIR__.'/vendor/yootheme/theme/bootstrap.php';
    $cfg = require __DIR__.'/config.php';

    $app->addLoader(new ConfigLoader($cfg));
    $app->addLoader(function ($options, $next) {

        $module = $next($options);

        if ($module instanceof Theme) {
            $module->template = basename(__DIR__);
        }

        return $module;
    });

    $app->register('config.php', __DIR__);
    $app->load($cfg['name']);
    $app->init();

    $theme = $app['theme'];
});

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @link https://codex.wordpress.org/Function_Reference/add_theme_support
 */
add_action('after_setup_theme', function () {

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    // Enable support for Post Formats. (https://developer.wordpress.org/themes/functionality/post-formats)
    add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));

    // Enable support for WooCommerce
    add_theme_support('woocommerce');

    // Enable support for prefixed Widgetkit
    add_theme_support('widgetkit-noconflict');

    // Load theme translations
    load_theme_textdomain('yootheme', get_template_directory() . '/language');
});

/**
 * Register navigation menus.
 *
 * @link https://developer.wordpress.org/themes/functionality/navigation-menus
 */
add_action('init', function () {

    global $theme;

    // Register menu locations.
    foreach ($theme->options['menus'] as $id => $name) {
        register_nav_menu($id, __($name));
    }

    // Add filter to menu arguments.
    add_filter('wp_nav_menu_args', function ($args) use ($theme) {
        return array_replace($args, array(
            'walker' => new MenuWalker($theme, get_current_sidebar(), $args),
            'container' => false,
            'fallback_cb' => false,
            'items_wrap' => '%3$s',
        ));
    });

    add_filter('widget_nav_menu_args', function ($nav_menu_args, $nav_menu, $args, $instance) {
        $menu_args = array_replace($nav_menu_args, json_decode(isset($instance[$key = '_theme']) ? $instance[$key] : '{}', true));

        if (isset($args['yoo_element'])) {
            $menu_args = array_merge($args, $args['yoo_element']->props);
        }

        return $menu_args;
    }, 10, 4);

});

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars
 */
add_action('widgets_init', function () {

    global $theme;

    foreach ($theme->options['positions'] as $id => $name) {
        register_sidebar(array(
            'id' => $id,
            'name' => $name,
            'before_widget' => '<content>',
            'after_widget' => '</content>',
            'before_title' => '<title>',
            'after_title' => '</title>'
        ));
    }

});

/**
 * Add theme to query vars for access in template parts.
 */
add_action('wp', function () {

    global $wp_query, $theme;

    $wp_query->query_vars['theme'] = $theme;
});

/**
 * Add comment scripts for the front end.
 */
add_action('wp_enqueue_scripts', function () {

    if (is_singular() && comments_open()) {
        wp_enqueue_script('comment-reply');
    }

});

/**
 * Add filter to comment classes.
 */
add_filter('comment_class', function ($classes) {

    if (in_array('byuser', $classes)) {
        $classes[] = 'uk-comment-primary';
    }

    return $classes;
});

/**
 * Add filter to comment edit link.
 */
// add_filter('edit_comment_link', function ($link) {
//     return str_replace('comment-edit-link', 'uk-button uk-button-text', $link);
// });

/**
 * Add filter to comment reply link.
 */
add_filter('comment_reply_link', function ($link) {
    return str_replace('comment-reply-link', 'uk-button uk-button-text', $link);
});

/**
 * Add filter to comment cancel reply link.
 */
add_filter('cancel_comment_reply_link', function ($link) {
    return str_replace('href="', 'class="uk-link-muted" href="', $link);
});

/**
 * Add filter to comment author link.
 */
add_filter('get_comment_author_link', function ($link) {
    return str_replace("class='url'", 'class="uk-link-reset"', $link);
});

/**
 * Add filter to page links.
 */
add_filter('wp_link_pages_link', function ($link) {
    return is_numeric($link) ? "<li class=\"uk-active\"><span>{$link}</span></li>" : "<li>{$link}</li>";
});

/**
 * Register theme helper functions.
 */
function get_view() {

    global $theme;

    return call_user_func_array([$theme['view'], 'render'], func_get_args());
}

function get_section() {

    global $theme;

    return call_user_func_array([$theme['view'], 'section'], func_get_args());
}

function get_attrs() {

    global $theme;

    return call_user_func_array([$theme['view'], 'attrs'], func_get_args());
}

function get_builder() {

    global $theme;

    return call_user_func_array([$theme['builder'], 'render'], func_get_args());
}

function get_current_sidebar() {

    global $theme;

    return $theme['modules']->get('yootheme/wordpress-widgets')->sidebar;
}

function get_readmore() {

    $post = get_post();
    $text = get_extended($post->post_content);

    return !empty($text['extended']) ? $text['more_text'] ?: __('Continue reading', 'yootheme') : false;
}

function get_post_date() {
    return '<time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time>';
}

function get_post_author() {
    return '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>';
}

function get_post_columns($count, $mode = 1) {

    global $wp_query;

    $posts = $wp_query->posts;
    $count = max(1, $count);
    $columns = [];

    if ($mode == 0) {

        while ($posts) {
            $columns[] = array_splice($posts, 0, ceil(count($posts) / ($count - count($columns))));
        }

    } else {

        foreach ($posts as $i => $post) {
            $columns[$i % $count][] = $post;
        }
    }

    return $columns;
}
