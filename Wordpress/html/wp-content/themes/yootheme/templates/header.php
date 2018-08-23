<?php

// Options
$layout = $theme->get('header.layout');
$fullwidth = $theme->get('header.fullwidth');
$logo = $theme->get('logo.image') || $theme->get('logo.text');
$class = array_merge(['tm-header', 'uk-visible@' . $theme->get('mobile.breakpoint')], isset($class) ? (array) $class : []);
$attrs = array_merge(['uk-header' => true], isset($attrs) ? (array) $attrs : []);

// Container
$container = ['class' => ['uk-navbar-container']];

// Navbar
$navbar = $theme->get('navbar', []);
$navbar_attrs = [
    'class' => 'uk-navbar',
    'uk-navbar' => json_encode(array_filter([
        'align' => $navbar['dropdown_align'],
        'click' => $navbar['dropdown_click'],
        'boundary-align' => $navbar['dropdown_boundary'],
        'dropbar' => $navbar['dropbar'] ? true : null,
        'dropbar-anchor' => $navbar['dropbar'] ? '!.uk-container' : null,
        'dropbar-mode' => $navbar['dropbar']
    ]))
];

// Sticky
if ($sticky = $navbar['sticky']) {
    $container = array_merge($container, array_filter([
        'uk-sticky' => true,
        'media' => 768,
        'show-on-up' => $sticky == 2,
        'animation' => $sticky == 2 ? 'uk-animation-slide-top' : '',
        'cls-active' => 'uk-active uk-navbar-sticky',
    ]));
}

?>

<div<?= $this->attrs(['class' => $class], $attrs) ?>>

<?php

/*
 * Horizontal layouts
 */

if (in_array($layout, ['horizontal-left', 'horizontal-center', 'horizontal-right'])) : ?>
    <div<?= $this->attrs($container) ?>>

        <div class="uk-container <?= $fullwidth ? 'uk-container-expand' : '' ?>">
            <nav<?= $this->attrs($navbar_attrs) ?>>

                <?php if ($logo || $layout == 'horizontal-left' && is_active_sidebar('navbar')) : ?>
                <div class="uk-navbar-left">

                    <?= $logo ? $this->render('header-logo', ['class' => 'uk-navbar-item', 'img' => 'uk-responsive-height']) : '' ?>

                    <?php if ($layout == 'horizontal-left') : ?>
                        <?php dynamic_sidebar("navbar") ?>
                    <?php endif ?>

                </div>
                <?php endif ?>

                <?php if ($layout == 'horizontal-center' && is_active_sidebar('navbar')) : ?>
                <div class="uk-navbar-center">
                    <?php dynamic_sidebar("navbar") ?>
                </div>
                <?php endif ?>

                <?php if (is_active_sidebar('header') || $layout == 'horizontal-right' && is_active_sidebar('navbar')) : ?>
                <div class="uk-navbar-right">

                    <?php if ($layout == 'horizontal-right' && is_active_sidebar('navbar')) : ?>
                        <?php dynamic_sidebar("navbar") ?>
                    <?php endif ?>

                    <?php dynamic_sidebar("header") ?>

                </div>
                <?php endif ?>

            </nav>
        </div>

    </div>
<?php endif ?>

<?php

/*
 * Stacked Center layouts
 */

if (in_array($layout, ['stacked-center-a', 'stacked-center-b', 'stacked-center-split'])) : ?>

    <?php if ($logo && $layout != 'stacked-center-split' || $layout == 'stacked-center-a' && is_active_sidebar('header')) : ?>
    <div class="tm-headerbar-top">
        <div class="uk-container<?= $fullwidth ? ' uk-container-expand' : '' ?>">

            <?php if ($logo) : ?>
            <div class="uk-text-center">
                <?= $this->render('header-logo') ?>
            </div>
            <?php endif ?>

            <?php if ($layout == 'stacked-center-a' && is_active_sidebar('header')) : ?>
            <div class="tm-headerbar-stacked uk-grid-medium uk-child-width-auto uk-flex-center uk-flex-middle" uk-grid>
                <?php dynamic_sidebar("header:cell") ?>
            </div>
            <?php endif ?>

        </div>
    </div>
    <?php endif ?>

    <?php if (is_active_sidebar('navbar')) : ?>
    <div<?= $this->attrs($container) ?>>

        <div class="uk-container <?= $fullwidth ? 'uk-container-expand' : '' ?>">
            <nav<?= $this->attrs($navbar_attrs) ?>>

                <div class="uk-navbar-center">

                    <?php if ($layout == 'stacked-center-split') : ?>

                        <div class="uk-navbar-center-left"><div>
                            <?php dynamic_sidebar("navbar-split") ?>
                        </div></div>

                        <?= $this->render('header-logo', ['class' => 'uk-navbar-item', 'img' => 'uk-responsive-height']); ?>

                        <div class="uk-navbar-center-right"><div>
                            <?php dynamic_sidebar("navbar") ?>
                        </div></div>

                    <?php else: ?>
                        <?php dynamic_sidebar("navbar") ?>
                    <?php endif ?>

                </div>

            </nav>
        </div>

    </div>
    <?php endif ?>

    <?php if (in_array($layout, ['stacked-center-b', 'stacked-center-split']) && is_active_sidebar('header')) : ?>
    <div class="tm-headerbar-bottom">
        <div class="uk-container <?= $fullwidth ? 'uk-container-expand' : '' ?>">
            <div class="uk-grid-medium uk-child-width-auto uk-flex-center uk-flex-middle" uk-grid>
                <?php dynamic_sidebar("header:cell") ?>
            </div>
        </div>
    </div>
    <?php endif ?>

<?php endif ?>

<?php

/*
 * Stacked Left layouts
 */

if ($layout == 'stacked-left-a' || $layout == 'stacked-left-b') : ?>

    <?php if ($logo || is_active_sidebar('header')) : ?>
    <div class="tm-headerbar-top">
        <div class="uk-container <?= $fullwidth ? 'uk-container-expand' : '' ?> uk-flex uk-flex-middle">

            <?= $logo ? $this->render('header-logo') : '' ?>

            <?php if (is_active_sidebar('header')) : ?>
            <div class="uk-margin-auto-left">
                <div class="uk-grid-medium uk-child-width-auto uk-flex-middle" uk-grid>
                    <?php dynamic_sidebar("header:cell") ?>
                </div>
            </div>
            <?php endif ?>

        </div>
    </div>
    <?php endif ?>

    <?php if (is_active_sidebar('navbar')) : ?>
    <div<?= $this->attrs($container) ?>>

        <div class="uk-container <?= $fullwidth ? 'uk-container-expand' : '' ?>">
            <nav<?= $this->attrs($navbar_attrs) ?>>

                <?php if ($layout == 'stacked-left-a') : ?>
                <div class="uk-navbar-left">
                    <?php dynamic_sidebar("navbar") ?>
                </div>
                <?php endif ?>

                <?php if ($layout == 'stacked-left-b') : ?>
                <div class="uk-navbar-left uk-flex-auto">
                    <?php dynamic_sidebar("navbar") ?>
                </div>
                <?php endif ?>

            </nav>
        </div>

    </div>
    <?php endif ?>

<?php endif ?>

<?php

/*
 * Toggle layouts
 */

if ($layout == 'toggle-offcanvas' || $layout == 'toggle-modal') : ?>

    <div<?= $this->attrs($container) ?>>
        <div class="uk-container <?= $fullwidth ? 'uk-container-expand' : '' ?>">
            <nav<?= $this->attrs($navbar_attrs) ?>>

            <?php if ($logo) : ?>
            <div class="uk-navbar-left">
                <?= $this->render('header-logo', ['class' => 'uk-navbar-item', 'img' => 'uk-responsive-height']) ?>
            </div>
            <?php endif ?>

            <?php if (is_active_sidebar('navbar')) : ?>
            <div class="uk-navbar-right">
                <a class="uk-navbar-toggle" href="#" uk-toggle="target: !.uk-navbar-container + [uk-offcanvas], [uk-modal]">
                    <?php if ($navbar['toggle_text']) : ?>
                    <span class="uk-margin-small-right"><?= __('Menu', 'yootheme') ?></span>
                    <?php endif ?>
                    <div uk-navbar-toggle-icon></div>
                </a>
            </div>
            <?php endif ?>

            </nav>
        </div>
    </div>

    <?php if ($layout == 'toggle-offcanvas' && (is_active_sidebar('navbar') || is_active_sidebar('header'))) : ?>
    <div uk-offcanvas="flip: true"<?= $this->attrs($navbar['offcanvas'] ?: []) ?>>
        <div class="uk-offcanvas-bar">

            <?php dynamic_sidebar("navbar") ?>

            <?php if (is_active_sidebar('header')) : ?>
            <div class="uk-margin-large-top">
                <?php dynamic_sidebar("header:grid-stack") ?>
            </div>
            <?php endif ?>

        </div>
    </div>
    <?php endif ?>

    <?php if ($layout == 'toggle-modal' && (is_active_sidebar('navbar') || is_active_sidebar('header'))) : ?>
    <div class="uk-modal-full" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-full" type="button" uk-close></button>
            <div class="uk-flex uk-flex-center uk-flex-middle uk-text-center" uk-height-viewport>
                <div>

                    <?php dynamic_sidebar("navbar") ?>

                    <?php if (is_active_sidebar('header')) : ?>
                    <div class="uk-margin-large-top">
                        <?php dynamic_sidebar("header:grid-stack") ?>
                    </div>
                    <?php endif ?>

                </div>
            </div>
        </div>
    </div>
    <?php endif ?>

<?php endif ?>

</div>
