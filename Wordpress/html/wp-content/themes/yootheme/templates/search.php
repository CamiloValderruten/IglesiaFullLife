<?php

$style = '';
$search = &$fields[0];
$toggle = ['class' => []];
$layout = $theme->get('header.layout');
$navbar = $theme->get('navbar', []);

$attrs['class'] = array_merge(['uk-search'], isset($attrs['class']) ? (array) $attrs['class'] : []);

if ($header = in_array($position, ['navbar', 'header'])) {
    if ($horizontal = strrpos($layout, 'horizontal-', 0) !== false) {
        $style = $theme->get('header.search_navbar');
    } else if (strrpos($layout, 'stacked-', 0) !== false) {
        $style = $theme->get("header.search_{$position}");
    }
}

$search['type'] = 'search';
$search['class'][] = 'uk-search-input';

if ($style) {
    $search['autofocus'] = true;
}

if ($style == 'modal') {
    $search['class'][] = 'uk-text-center';
    $attrs['class'][] = 'uk-search-large';
} else {
    $attrs['class'][] = 'uk-search-default';
}

if (in_array($style, ['dropdown', 'justify'])) {
    $attrs['class'][] = 'uk-width-1-1';
}

?>

<?php if ($style != 'modal') : // TODO renders the default style only ?>

    <?= $this->form(array_merge([['tag' => 'span', 'uk-search-icon' => true]], $fields), $attrs) ?>

<?php elseif (false && $style == 'drop') : ?>

    <a<?= $this->attrs($toggle) ?> href="#" uk-search-icon></a>
    <div uk-drop="mode: click; pos: left-center; offset: 0">
        <?= $this->form($fields, $attrs) ?>
    </div>

<?php elseif (false && in_array($style, ['dropdown', 'justify'])) : ?>

    <?php

    $drop = [
        'mode' => 'click',
        'cls-drop' => 'uk-navbar-dropdown',
        'boundary' => $navbar['dropdown_align'] ? '!nav' : false,
        'boundary-align' => $navbar['dropdown_boundary'],
        'pos' => $style == 'justify' ? 'bottom-justify' : 'bottom-right',
        'flip' => 'x'
    ];

    ?>

    <a<?= $this->attrs($toggle) ?> href="#" uk-search-icon></a>
    <div class="uk-navbar-dropdown" <?= $this->attrs(['uk-drop' => json_encode(array_filter($drop))]) ?>>

        <div class="uk-grid uk-grid-small uk-flex-middle">
            <div class="uk-width-expand">
                <?= $this->form($fields, $attrs) ?>
            </div>
            <div class="uk-width-auto">
                <a class="uk-navbar-dropdown-close" href="#" uk-close></a>
            </div>
        </div>

    </div>

<?php elseif (true && $style == 'modal') : ?>

    <a<?= $this->attrs($toggle) ?> href="#<?= $id = $attrs['id'].'-modal' ?>" uk-search-icon uk-toggle></a>

    <div id="<?= $id ?>" class="uk-modal-full" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full" type="button" uk-close></button>
            <div class="uk-search uk-search-large">
                <?= $this->form($fields, $attrs) ?>
            </div>
        </div>
    </div>

<?php endif ?>
