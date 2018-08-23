<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <body>
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

$site = $theme->get('site', []);

// Boxed Page Layout
$boxed = $theme->get('site.boxed', []);
$boxed_class = ['tm-page'];
$boxed_class[] = $boxed['padding'] ? 'tm-page-padding' : '';
$boxed_style[] = $boxed['media'] ? "background-image: url('{$boxed['media']}');" : '';

?>
<!DOCTYPE html>
<html <?php language_attributes() ?>>
    <head>
        <meta charset="<?php bloginfo('charset') ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?= $theme->get('favicon') ?>">
        <link rel="apple-touch-icon-precomposed" href="<?= $theme->get('touchicon') ?>">
        <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url') ?>">
        <?php endif ?>
        <?php wp_head() ?>
    </head>
    <body <?php body_class($theme->get('body_class')->all()) ?>>

        <?php if ($site['layout'] == 'boxed') : ?>
        <div<?= get_attrs(['class' => $boxed_class, 'style' => $boxed_style]) ?>>
            <div <?= $boxed['alignment'] ? 'class="uk-margin-auto"' : '' ?>>
        <?php endif ?>

            <div class="tm-header-mobile uk-hidden@<?= $theme->get('mobile.breakpoint') ?>">
            <?= get_view('header-mobile') ?>
            </div>

            <?php if (is_active_sidebar('toolbar-left') || is_active_sidebar('toolbar-right')) : ?>
            <div class="tm-toolbar uk-visible@<?= $theme->get('mobile.breakpoint') ?>">
                <div class="uk-container uk-flex uk-flex-middle <?= $site['toolbar_fullwidth'] ? 'uk-container-expand' : '' ?>">

                    <?php if (is_active_sidebar('toolbar-left')) : ?>
                    <div>
                        <div class="uk-grid-medium uk-child-width-auto uk-flex-middle" uk-grid="margin: uk-margin-small-top">
                            <?php dynamic_sidebar("toolbar-left:cell") ?>
                        </div>
                    </div>
                    <?php endif ?>

                    <?php if (is_active_sidebar('toolbar-right')) : ?>
                    <div class="uk-margin-auto-left">
                        <div class="uk-grid-medium uk-child-width-auto uk-flex-middle" uk-grid="margin: uk-margin-small-top">
                            <?php dynamic_sidebar("toolbar-right:cell") ?>
                        </div>
                    </div>
                    <?php endif ?>

                </div>
            </div>
            <?php endif ?>

            <?= get_view('header') ?>

            <?= get_view('section', ['name' => 'top']) ?>

            <?php if (!$theme->get('builder')) : ?>

            <div id="tm-main" class="tm-main uk-section uk-section-default" uk-height-viewport="mode: expand">
                <div class="uk-container">

                    <?php
                        $grid = ['uk-grid']; $sidebar = $theme->get('sidebar', []);
                        $grid[] = $sidebar['gutter'] ? "uk-grid-{$sidebar['gutter']}" : '';
                        $grid[] = $sidebar['divider'] ? "uk-grid-divider" : '';
                    ?>

                    <div<?= get_attrs(['class' => $grid, 'uk-grid' => true]) ?>>
                        <div class="uk-width-expand@<?= $theme->get('sidebar.breakpoint') ?>">

                            <?php if ($site['breadcrumbs']) : ?>
                            <div class="uk-margin-medium-bottom">
                                <?= get_section('breadcrumbs') ?>
                            </div>
                            <?php endif ?>

            <?php endif ?>
