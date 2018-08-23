<?php

namespace YOOtheme\Theme;

use YOOtheme\EventSubscriberInterface;
use YOOtheme\Module;
use YOOtheme\Theme\Wordpress\Breadcrumbs;
use YOOtheme\Theme\Wordpress\ChildThemeListener;
use YOOtheme\Theme\Wordpress\ContentListener;
use YOOtheme\Theme\Wordpress\CustomizerListener;
use YOOtheme\Theme\Wordpress\UpgradeListener;
use YOOtheme\Theme\Wordpress\UrlListener;

class Wordpress extends Module implements EventSubscriberInterface
{
    /**
     * Query information.
     *
     * @var string[]
     */
    public $query;

    /**
     * {@inheritdoc}
     */
    public function __invoke($app)
    {
        $this['events']
            ->subscribe(new ChildThemeListener($this))
            ->subscribe(new ContentListener($this))
            ->subscribe(new CustomizerListener($this))
            ->subscribe(new UrlListener($this))
            ->subscribe(new UpgradeListener($this));
        $this['locator']->addPath("{$this->path}/assets", 'assets');
    }

    public function onInit($theme)
    {
        add_action('wp_loaded', function () use ($theme) {

            $config = json_decode(get_theme_mod('config', '{}'), true);
            $theme->merge($config, true);

            if (!$this['admin']) {
                $this['events']->trigger('theme.site', [$theme]);
            } elseif ($theme['@customizer']->isActive()) {
                $this['events']->trigger('theme.admin', [$theme]);
            }

        });

        add_filter('upload_mimes', function ($mimes) {

            $mimes['svg|svgz'] = 'image/svg+xml';

            return $mimes;
        });

        add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

            if (empty($data['type']) && substr($filename, -4) === '.svg') {
                $data['ext'] = 'svg';
                $data['type'] = 'image/svg+xml';
            }

            return $data;

        }, 10, 4);

        add_action('edit_form_after_title', function ($post) {

            if ($post->post_type != 'page' || $post->post_status == 'auto-draft') {
                return;
            }

            $link = add_query_arg(['url' => urlencode(get_permalink($post->ID)), 'autofocus[section]' => 'builder'], wp_customize_url());

            echo '<div class="tm-editor" hidden><a href="'.$link.'" class="tm-button">'.__('Page Builder', 'yootheme').'</a><a class="tm-link">'.__('&#8592; Back to WordPress Editor', 'yootheme').'</a></div>';

            add_filter('wp_editor_settings', function ($settings) use ($post) {

                if (preg_match('/<!--\s?\{/', ($post->post_content))) {
                    $settings['default_editor'] = 'html';
                }

                return $settings;
            });

            add_action('media_buttons_context', function ($context) use ($link) {
                return $context.'<a href="'.$link.'" class="button"><span class="wp-media-buttons-icon dashicons-admin-appearance" style="font: 400 18px/1 dashicons"></span> '.__('Page Builder', 'yootheme').'</a>';
            });

            add_action('admin_footer', function () {

                echo '<style>

                    .tm-editor {
                        width: 100%;
                        height: 300px;
                        background: #FFF;
                        border: solid #DDD 1px;
                        margin-top: 20px;
                        text-align: center;
                    }

                    .tm-link {
                        display: inline-block;
                        margin: 20px auto;
                        color: #888;
                    }

                    .tm-button {
                        display: block;
                        box-sizing: border-box;
                        width: 280px;
                        max-width: 100%;
                        margin: 125px auto 0 auto;
                        padding: 20px 30px;
                        border-radius: 2px;
                        background: linear-gradient(140deg, #FE67D4, #4956E3);
                        box-shadow: inset 0 0 1px 0 rgba(0,0,0,0.5);
                        line-height: 10px;
                        vertical-align: middle;
                        color: #fff !important;
                        font-size: 11px;
                        font-weight: bold;
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                        text-align: center;
                        text-decoration: none !important;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        -webkit-font-smoothing: antialiased;
                    }

                </style>';

                echo '<script>

                    (function ($) {

                        var active = $("#content").val().match(/<!-- \\{/);

                        function init(active) {
                            $(".tm-editor").attr("hidden", !active);
                            $("#postdivrich").attr("hidden", !!active);
                            $(window).resize();
                        }

                        $(".tm-link").click(function (e) {
                            e.preventDefault(); init();
                        });

                        init(active);

                    })(jQuery);

                </script>';

            });

        });

    }

    public function onSite($theme)
    {
        $theme
            ->set('directions', is_rtl() ? 'rtl' : 'lrt')
            ->set('site_url', rtrim(get_bloginfo('url'), '/'))
            ->set('page_class', ''); // TODO: implement page class builder

        if ($theme->get('disable_wpautop')) {
            remove_filter('the_content', 'wpautop');
            remove_filter('the_excerpt', 'wpautop');
        }

        add_filter('wp_title', function ($title, $sep) {

            if (is_feed()) {
                return $title;
            }

            // add the site name.
            $title .= get_bloginfo('name', 'display');

            // add the site description for the home/front page.
            $site_description = get_bloginfo('description', 'display');
            if ($site_description && (is_home() || is_front_page())) {
                $title = "$title $sep $site_description";
            }

            return $title;
        }, 10, 2);

        $this['view']['sections']->add('breadcrumbs', function () {
            return $this['view']->render('breadcrumbs', ['items' => Breadcrumbs::getItems()]);
        });

        add_action('wp_footer', function () use ($theme) {
            if (get_post_type() !== 'page' && isset($theme['@customizer']) && $theme['@customizer']->isActive() && $theme->get('uikit_dev')) {
                theme_section('builder');
            }
        });

        // WooCommerce integration
        include_once(ABSPATH.'wp-admin/includes/plugin.php');

        if (is_plugin_active('woocommerce/woocommerce.php')) {

            // disable woocommerce general style
            add_filter('woocommerce_enqueue_styles', function ($styles) {
                unset($styles['woocommerce-general']);
                return $styles;
            });

            // number of items per page
            if ($theme->get('woocommerce.items', 'default') !== 'default') {
                add_filter('loop_shop_per_page', function () use ($theme) {
                    return $theme->get('woocommerce.items');
                }, 20);
            }
        }

        $this['theme']->set('uikit_dev', get_theme_mod('uikit_dev'));

        $this['builder']->addRenderer(function ($element, $type, $next) {
            return do_shortcode($next($element, $type));
        });
    }

    public function onContent($obj)
    {
        if (!$this['view']['sections']->exists('builder') && isset($obj->content)) {
            $this['view']['sections']->set('builder', function () use ($obj) {
                $result = $this['builder']->render($obj->content, 'page');
                $this['events']->trigger('content', [$result]);
                return $result;
            });
        }

        $this['theme']->set('builder', $this['view']['sections']->exists('builder'));
    }

    public static function getSubscribedEvents()
    {
        return [
            'theme.init' => ['onInit', -10],
            'theme.site' => ['onSite', 10],
            'content.prepare' => 'onContent'
        ];
    }
}
