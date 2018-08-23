<?php

// Options
$logo = $theme->get('logo', []);
$mobile = $theme->get('mobile', []);

if ($logo['image_mobile']) {
    $logo['image'] = $logo['image_mobile'];
}

$logo = $logo['image'] ? $this->image($logo['image'], ['alt' => $logo['text'], 'class' => 'uk-responsive-height']) : $logo['text'];

if (!$logo) {
    unset($mobile['logo']);
}

if (!is_active_sidebar('mobile')) {
    unset($mobile['toggle']);
}

$mobile['search'] = false; // TODO

?>

<nav class="uk-navbar-container" uk-navbar>

    <?php if ($mobile['logo'] == 'left' || $mobile['toggle'] == 'left' || $mobile['search'] == 'left') : ?>
    <div class="uk-navbar-left">

        <?php if ($mobile['toggle'] == 'left') : ?>
        <a class="uk-navbar-toggle" href="#tm-mobile" uk-toggle<?= ($mobile['animation'] == 'dropdown') ? '="animation: true"' : '' ?>>
            <div uk-navbar-toggle-icon></div>
            <?php if ($mobile['toggle_text']) : ?>
            <span class="uk-margin-small-left"><?= __('Menu', 'yootheme') ?></span>
            <?php endif ?>
        </a>
        <?php endif ?>

        <?php if ($mobile['search'] == 'left') : ?>
        <a class="uk-navbar-item"><?= __('Search', 'yootheme') ?></a>
        <?php endif ?>

        <?php if ($mobile['logo'] == 'left') : ?>
        <a class="uk-navbar-item uk-logo" href="<?= $theme->get('site_url') ?>">
            <?= $logo ?>
        </a>
        <?php endif ?>

    </div>
    <?php endif ?>

    <?php if ($mobile['logo'] == 'center') : ?>
    <div class="uk-navbar-center">
        <a class="uk-navbar-item uk-logo" href="<?= $theme->get('site_url') ?>">
            <?= $logo ?>
        </a>
    </div>
    <?php endif ?>

    <?php if ($mobile['logo'] == 'right' || $mobile['toggle'] == 'right' || $mobile['search'] == 'right') : ?>
    <div class="uk-navbar-right">

        <?php if ($mobile['logo'] == 'right') : ?>
        <a class="uk-navbar-item uk-logo" href="<?= $theme->get('site_url') ?>">
            <?= $logo ?>
        </a>
        <?php endif ?>

        <?php if ($mobile['search'] == 'right') : ?>
        <a class="uk-navbar-item"><?= __('Search', 'yootheme') ?></a>
        <?php endif ?>

        <?php if ($mobile['toggle'] == 'right') : ?>
        <a class="uk-navbar-toggle" href="#tm-mobile" uk-toggle<?= $mobile['animation'] == 'dropdown' ? '="animation: true"' : '' ?>>
            <?php if ($mobile['toggle_text']) : ?>
            <span class="uk-margin-small-right"><?= __('Menu', 'yootheme') ?></span>
            <?php endif ?>
            <div uk-navbar-toggle-icon></div>
        </a>
        <?php endif ?>

    </div>
    <?php endif ?>

</nav>

<?php if (is_active_sidebar('mobile')) : ?>

    <?php if ($mobile['animation'] == 'offcanvas') : ?>
    <div id="tm-mobile" uk-offcanvas<?= $this->attrs($mobile['offcanvas'] ?: []) ?>>
        <div class="uk-offcanvas-bar">
            <?php dynamic_sidebar("mobile:grid-stack") ?>
        </div>
    </div>
    <?php endif ?>

    <?php if ($mobile['animation'] == 'modal') : ?>
    <div id="tm-mobile" class="uk-modal-full" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-full" type="button" uk-close></button>
            <div class="uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
                <?php dynamic_sidebar("mobile:grid-stack") ?>
            </div>
        </div>
    </div>
    <?php endif ?>

    <?php if ($mobile['animation'] == 'dropdown') : ?>
    <div class="uk-position-relative uk-position-z-index">
        <div id="tm-mobile" class="<?= $mobile['dropdown'] == 'slide' ? 'uk-position-top' : '' ?>" hidden>
            <div class="uk-background-default uk-padding">
                <?php dynamic_sidebar("mobile:grid-stack") ?>
            </div>
        </div>
    </div>
    <?php endif ?>

<?php endif ?>
