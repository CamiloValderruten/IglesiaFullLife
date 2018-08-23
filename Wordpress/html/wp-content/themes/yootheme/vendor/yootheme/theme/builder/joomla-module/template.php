<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_title = [];

// Style
$class[] = $element['style'] ? "uk-card uk-card-body uk-{$element['style']}" : 'uk-panel';

// List
if ($element['is_list']) {
    $class[] = "tm-child-list";

    // List Style?
    if ($element['list_style']) {
        $class[] = "tm-child-list-{$element['list_style']}";
    }

    // Link Style?
    if ($element['link_style']) {
        $class[] = "uk-link-{$element['link_style']}";
    }

}

// Title
if ($element['showtitle']) {

    // Style?
    $attrs_title['class'][] = $element['title_style'] ? "uk-{$element['title_style']}" : '';
    $attrs_title['class'][] = $element['style'] && !$element['title_style'] ? "uk-card-title" : '';

    // Decoration?
    $attrs_title['class'][] = $element['title_decoration'] ? "uk-heading-{$element['title_decoration']}" : '';

    // Color
    $attrs_title['class'][] = $element['title_color'] && $element['title_color'] != 'background' ? "uk-text-{$element['title_color']}" : '';

}

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php if ($element['showtitle']) : ?>
        <?php if ($element['title_color'] == 'background') : ?>
            <h3<?= $this->attrs($attrs_title) ?>><span class="uk-text-background"><?= $element->title ?></span><h3>
        <?php elseif ($element['title_decoration'] == 'line') : ?>
            <h3<?= $this->attrs($attrs_title) ?>><span><?= $element->title ?></span><h3>
        <?php else: ?>
            <h3<?= $this->attrs($attrs_title) ?>><?= $element->title ?></h3>
        <?php endif ?>
    <?php endif ?>

    <?= $element ?>

</div>
