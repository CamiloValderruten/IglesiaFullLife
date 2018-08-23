<?php

namespace YOOtheme\Theme;

class WordpressQuery
{
    /*
     * Query information.
     *
     * @var string[]
     */
    public $query;

    /**
     * Get current query information.
     *
     * @global \WP_Query $wp_query
     *
     * @return string[]
     */
    public function getQuery()
    {
        global $wp_query;

        // create, if not set
        if (empty($this->query)) {

            // init vars
            $obj = $wp_query->get_queried_object();
            $type = get_post_type();
            $query = [];

            if (is_home()) {
                $query[] = 'home';
            }

            if (is_front_page()) {
                $query[] = 'front_page';
            }

            if ($type == 'post') {

                if (is_single()) {
                    $query[] = 'single';
                }

                if (is_archive()) {
                    $query[] = 'archive';
                }

                if (is_search()) {
                    $query[] = 'search';
                }

            } else {
                if (is_single()) {
                    $query[] = $type.'-single';
                } elseif (is_search()) {
                    $query[] = $type.'-search';
                } elseif (is_archive()) {
                    $query[] = $type.'-archive';
                }
            }

            if (is_page()) {
                $query[] = $type;
                $query[] = $type.'-'.$obj->ID;
            }

            if (is_category()) {
                $query[] = 'cat-'.$obj->term_id;
            }

            // WooCommerce
            if (is_plugin_active('woocommerce/woocommerce.php')) {

                if (is_shop() && !is_search()) {
                    $query[] = 'page';
                    $query[] = 'page-'.wc_get_page_id('shop');
                }

                if (is_product_category() || is_product_tag()) {
                    $query[] = 'cat-'.$obj->term_id;
                }

            }

            // WPML support
            if (defined('ICL_LANGUAGE_CODE') && function_exists('icl_get_default_language') && ICL_LANGUAGE_CODE != ($lang = icl_get_default_language())) {

                if ($type == 'page') {
                    $query[] = 'page-'.icl_object_id($obj->ID, $type, true, $lang);
                }

                if ($type == 'category') {
                    $query[] = 'cat-'.icl_object_id($obj->term_id, $type, true, $lang);
                }
            }

            $this->query = $query;
        }

        return $this->query;
    }

}
