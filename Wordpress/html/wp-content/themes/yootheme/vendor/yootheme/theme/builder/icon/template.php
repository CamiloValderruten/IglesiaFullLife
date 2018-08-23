<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_icon = [];

// Icon
$options = ["icon: {$element['icon']}"];
$options[] = ($element['icon_ratio'] && $element['link_style'] != 'button') ? "ratio: {$element['icon_ratio']}" : '';
$attrs_icon['uk-icon'] = implode(';', array_filter($options));

$attrs_icon['class'][] = ($element['icon_color'] && !$element['link']) ? "uk-text-{$element['icon_color']}" : '';

// Link
if ($element['link']) {

    $attrs_icon['href'] = $element['link'];
    $attrs_icon['target'] = $element['link_target'] ? '_blank' : '';
    $attrs_icon['uk-scroll'] = (strpos($element['link'], '#') === 0) ? true : false;

    switch ($element['link_style']) {
        case '':
            $attrs_icon['class'][] = "uk-icon-link";
            break;
        case 'button':
            $attrs_icon['class'][] = 'uk-icon-button';
            break;
        case 'link':
            $attrs_icon['class'][] = "";
            break;
        case 'muted':
            $attrs_icon['class'][] = "uk-link-muted";
            break;
        case 'reset':
            $attrs_icon['class'][] = "uk-link-reset";
            break;
    }
}

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php if ($element['link']) : ?>
    <a<?= $this->attrs($attrs_icon) ?>></a>
    <?php else : ?>
    <span<?= $this->attrs($attrs_icon) ?>></span>
    <?php endif ?>

</div>
