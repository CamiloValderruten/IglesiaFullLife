<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_image = [];
$attrs_link = [];

// Image
$attrs_image['class'][] = $element['image_border'] ? "uk-border-{$element['image_border']}" : '';
$attrs_image['class'][] = $element['image_box_shadow'] ? "uk-box-shadow-{$element['image_box_shadow']}" : '';
$attrs_image['class'][] = $element['link'] && $element['image_hover_box_shadow'] ? "uk-box-shadow-hover-{$element['image_hover_box_shadow']}" : '';
$attrs_image['alt'] = $element['image_alt'];

if (pathinfo($element['image'], PATHINFO_EXTENSION) == 'svg') {
    $element['image'] = $this->image($element['image'], array_merge($attrs_image, ['width' => $element['image_width'], 'height' => $element['image_height']]));
} elseif ($element['image_width'] || $element['image_height']) {
    $element['image'] = $this->image([$element['image'], 'thumbnail' => [$element['image_width'], $element['image_height']], 'sizes' => '80%,200%'], $attrs_image);
} else {
    $element['image'] = $this->image($element['image'], $attrs_image);
}

// Link
$attrs_link['target'] = $element['link_target'] ? '_blank' : '';
$attrs_link['uk-scroll'] = (strpos($element['link'], '#') === 0) ? true : false;

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php if ($element['link']) : ?>
    <?= $this->link($element['image'], $element['link'], $attrs_link) ?>
    <?php else : ?>
    <?= $element['image'] ?>
    <?php endif ?>

</div>
