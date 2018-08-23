<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Theme;

class Breadcrumbs
{
    public static function getItems()
    {
        global $wp_query;

        $getCategories = function ($category, $categories = []) use (&$getCategories) {

            if ($category->parent) {
                $getCategories(get_term($category->parent, 'category'), $categories);
            }

            $categories[] = ['name' => $category->name, 'link' => esc_url(get_category_link($category->term_id))];

            return $categories;
        };

        $items[] = ['name' => __('Home'), 'link' => get_option('home')];

        if (!is_home() && !is_front_page()) {

            if (is_single() and $categories = get_the_category() and $category = $categories[0] and is_object($category)) {
                array_merge($items, $getCategories($category));
            }

            if (is_category()) {
                array_merge($items, $getCategories($wp_query->get_queried_object()));
            } elseif (is_tag()) {
                $items[] = ['name' => single_cat_title('', false), 'link' => ''];
            } elseif (is_date()) {
                $items[] = ['name' => single_month_title(' ', false), 'link' => ''];
            } elseif (is_author()) {
                $user = !empty($wp_query->query_vars['author_name']) ? get_userdatabylogin($wp_query->query_vars['author']) : get_user_by("id", ((int) $_GET['author']));
                $items[] = ['name' => $user->display_name, 'link' => ''];
            } elseif (is_search()) {
                $items[] = ['name' => stripslashes(strip_tags(get_search_query())), 'link' => ''];
            } elseif (is_tax()) {
                $taxonomy = get_taxonomy(get_query_var('taxonomy'));
                $term = get_query_var('term');
                $items[] = ['name' => "{$taxonomy->label}: {$term}", 'link' => ''];
            } elseif (is_archive()) {
                // woocommerce shop page
                if (is_plugin_active("woocommerce/woocommerce.php") && is_shop()) {
                    $title = wc_get_page_id('shop') ? get_the_title(wc_get_page_id('shop')) : '';
                    $items[] = ['name' => $title, 'link' => ''];
                }
            } else {
                $ancestors = get_ancestors(get_the_ID(), 'page');
                for ($i = count($ancestors) - 1; $i >= 0; $i--) {
                    $items[] = ['name' => get_the_title($ancestors[$i]), 'link' => get_page_link($ancestors[$i])];
                }
                $items[] = ['name' => get_the_title(), 'link' => ''];
            }

        }

        return array_map(function ($item) {
            return (object) $item;
        }, $items);
    }
}
