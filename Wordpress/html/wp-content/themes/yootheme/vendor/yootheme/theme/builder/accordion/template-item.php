<?php

$attrs_image = [];
$attrs_grid = [];
$attrs_cell_image = [];

// Display
if (!$element['show_image']) { $item['image'] = ''; }
if (!$element['show_link']) { $item['link'] = ''; }

// Image
if ($item['image']) {

    $src = $item['image'];

    $attrs_image['class'][] = $element['image_border'] ? "uk-border-{$element['image_border']}" : '';
    $attrs_image['alt'] = $item['image_alt'];

    if (pathinfo($item['image'], PATHINFO_EXTENSION) == 'svg') {
        $item['image'] = $this->image($src, array_merge($attrs_image, ['width' => $element['image_width'], 'height' => $element['image_height']]));
    } elseif ($element['image_width'] || $element['image_height']) {
        $item['image'] = $this->image([$src, 'thumbnail' => [$element['image_width'], $element['image_height']], 'sizes' => '80%,200%'], $attrs_image);
    } else {
        $item['image'] = $this->image($src, $attrs_image);
    }

}

// Image Align
$attrs_grid['class'][] = 'uk-child-width-expand';
$attrs_grid['class'][] = $element['image_gutter'] ? "uk-grid-{$element['image_gutter']}" : '';
$attrs_grid['class'][] = $element['image_vertical_align'] ? 'uk-flex-middle' : '';
$attrs_grid['uk-grid'] = true;

$attrs_cell_image['class'][] = "uk-width-{$element['image_grid_width']}@{$element['image_breakpoint']}";
$attrs_cell_image['class'][] = $element['image_align'] == 'right' ? "uk-flex-last@{$element['image_breakpoint']}" : '';

?>

<?php if ($item['image'] && in_array($element['image_align'], ['left', 'right'])) : ?>

    <div<?= $this->attrs($attrs_grid) ?>>
        <div<?= $this->attrs($attrs_cell_image) ?>>
            <?= $item['image'] ?>
        </div>
        <div>
            <?= $this->render('@builder/accordion/template-content', compact('item')) ?>
        </div>
    </div>

<?php else : ?>

    <?php if ($element['image_align'] == 'top') : ?>
    <?= $item['image'] ?>
    <?php endif ?>

    <?= $this->render('@builder/accordion/template-content', compact('item')) ?>

    <?php if ($element['image_align'] == 'bottom') : ?>
    <?= $item['image'] ?>
    <?php endif ?>

<?php endif ?>