<?php

$class = [];
$attrs_tile = [];

// Width
$index = $element->index;
$widths = $element['widths'] ?: array_map(function ($widths) use ($index) {
    // Deprecated
    return explode(',', $widths)[$index];
}, explode('|', $element->parent['layout']));
$breakpoints = ['s', 'm', 'l', 'xl'];
$breakpoint = $element->parent['breakpoint'];

// Above Breakpoint
$width = $widths[0] ?: 'expand';
$width = $width === 'fixed' ? $element->parent['fixed_width'] : $width;
$class[] = "uk-width-{$width}".($breakpoint ? "@{$breakpoint}" : '');

// Intermediate Breakpoint
if (isset($widths[1]) && $pos = array_search($breakpoint, $breakpoints)) {
    $breakpoint = $breakpoints[$pos-1];
    $width = $widths[1] ?: 'expand';
    $class[] = "uk-width-{$width}".($breakpoint ? "@{$breakpoint}" : '');
}

// Order
if (!isset($element->parent->children[$index + 1]) && $element->parent['order_last']) {
    $class[] = "uk-flex-first@{$breakpoint}";
}

// Visibility
$visibilities = ['xs', 's', 'm', 'l', 'xl'];
$visible = $element->count() ? 4 : false;

foreach ($element as $el) {
    $visible = min(array_search($el['visibility'], $visibilities), $visible);
}

if ($visible) {
    $element['visibility'] = $visibilities[$visible];
    $class[] = "uk-visible@{$visibilities[$visible]}";
}

/*
 * Column options
 */

// Tile
if ($element['style'] || $element['image']) {

    $class[] = 'uk-grid-item-match';
    $attrs_tile['class'][] = 'uk-tile';
    $attrs_tile['class'][] = $element['style'] ? "uk-tile-{$element['style']}" : '';

    // Padding
    switch ($element['padding']) {
        case '':
            break;
        case 'none':
            $attrs_tile['class'][] = 'uk-padding-remove';
            break;
        default:
            $attrs_tile['class'][] = "uk-padding-{$element['padding']}";
    }

    // Image
    if ($element['image']) {

        if ($element['image_width'] || $element['image_height']) {
            $element['image'] = "{$element['image']}?thumbnail={$element['image_width']},{$element['image_height']}";
        }

        $attrs_tile['style'][] = "background-image: url('{$app['image']->getUrl($element['image'])}');";

        // Settings
        $attrs_tile['class'][] = 'uk-background-norepeat';
        $attrs_tile['class'][] = $element['image_size'] ? "uk-background-{$element['image_size']}" : '';
        $attrs_tile['class'][] = $element['image_position'] ? "uk-background-{$element['image_position']}" : '';
        $attrs_tile['class'][] = $element['image_visibility'] ? "uk-background-image@{$element['image_visibility']}" : '';

    }

}

// Text color
if ($element['style'] == 'primary' || $element['style'] == 'secondary') {

    if ($element['preserve_color']) {
        $attrs_tile['class'][] = 'uk-preserve-color';
    }

} elseif (!$element['style'] || $element['image']) {

    if ($element['text_color']) {
        $class[] = "uk-{$element['text_color']}";
    }

}

// Match height if single panel element inside cell
if ($element->parent['match'] && !$element->parent['vertical_align'] && count($element) == 1 && $element->children[0]->type == 'panel') {

    if ($element['style'] || $element['image']) {
        $attrs_tile['class'][] = 'uk-grid-item-match';
    } else {
        $class[] = 'uk-grid-item-match';
    }

}

?>

<div<?= $this->attrs(compact('class')) ?>>

    <?php if ($attrs_tile) : ?>
    <div<?= $this->attrs($attrs_tile) ?>>
    <?php endif ?>

    <?= $element ?>

    <?php if ($attrs_tile) : ?>
    </div>
    <?php endif ?>

</div>
