<?php

$attrs_title = [];
$attrs_content = [];
$attrs_meta = [];

// Title
$attrs_title['class'][] = 'uk-margin';
$attrs_title['class'][] = $element['title_style'] ? "uk-{$element['title_style']}" : '';
$attrs_title['class'][] = $element['title_decoration'] ? "uk-heading-{$element['title_decoration']}" : '';
$attrs_title['class'][] = $element['title_color'] && $element['title_color'] != 'background' ? "uk-text-{$element['title_color']}" : '';
$attrs_title['class'][] = $element['overlay_hover'] && $element['title_transition'] ? "uk-transition-{$element['title_transition']}" : '';

// Meta
$attrs_meta['class'][] = 'uk-margin';
$attrs_meta['class'][] = $element['overlay_hover'] && $element['meta_transition'] ? "uk-transition-{$element['meta_transition']}" : '';

switch ($element['meta_style']) {
    case '':
        break;
    case 'meta':
    case 'muted':
        $attrs_meta['class'][] = "uk-text-{$element['meta_style']}";
        break;
    default:
        $attrs_meta['class'][] = "uk-{$element['meta_style']}";
}

if ($element['meta_align'] == 'top') {
    $attrs_meta['class'][] = 'uk-margin-remove-adjacent';
    $attrs_meta['class'][] = $element['meta_margin'] ? "uk-margin-{$element['meta_margin']}-bottom" : '';
}

if ($item['meta'] && $element['meta_align'] == 'bottom') {
    $attrs_title['class'][] = 'uk-margin-remove-adjacent';
    $attrs_title['class'][] = $element['meta_margin'] ? "uk-margin-{$element['meta_margin']}-bottom" : '';
}

// Content
$attrs_content['class'][] = 'uk-margin';
$attrs_content['class'][] = $element['content_style'] ? "uk-text-{$element['content_style']}" : '';
$attrs_content['class'][] = $element['overlay_hover'] && $element['content_transition'] ? "uk-transition-{$element['content_transition']}" : '';

?>

<?php if ($item['meta'] && $element['meta_align'] == 'top') : ?>
<div<?= $this->attrs($attrs_meta) ?>><?= $item['meta'] ?></div>
<?php endif ?>

<?php if ($item['title']) : ?>
<<?= $element['title_element'] . $this->attrs($attrs_title) ?>>
    <?php if ($element['title_color'] == 'background') : ?>
    <span class="uk-text-background"><?= $item['title'] ?></span>
    <?php elseif ($element['title_decoration'] == 'line') : ?>
    <span><?= $item['title'] ?></span>
    <?php else : ?>
    <?= $item['title'] ?>
    <?php endif ?>
</<?= $element['title_element'] ?>>
<?php endif ?>

<?php if ($item['meta'] && $element['meta_align'] == 'bottom') : ?>
<div<?= $this->attrs($attrs_meta) ?>><?= $item['meta'] ?></div>
<?php endif ?>

<?php if ($element['image_align'] == 'between') : ?>
<?= $element['image'] ?>
<?php endif ?>

<?php if ($item['content']) : ?>
<div<?= $this->attrs($attrs_content) ?>><?= $item['content'] ?></div>
<?php endif ?>
