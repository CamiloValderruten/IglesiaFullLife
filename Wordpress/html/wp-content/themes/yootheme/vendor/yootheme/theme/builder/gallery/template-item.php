<?php

$attrs_item = [];
$attrs_overlay = [];
$attrs_center = [];
$attrs_cover = [];
$attrs_image = [];
$attrs_image2 = [];
$attrs_link = [];

// Display
if (!$element['show_title']) { $item['title'] = ''; }
if (!$element['show_meta']) { $item['meta'] = ''; }
if (!$element['show_content']) { $item['content'] = ''; }
if (!$element['show_link']) { $item['link'] = ''; }
if (!$element['show_image2']) { $item['image2'] = ''; }

// Animation
if ($element['item_animation'] != 'none' && $element->parent('section', 'animation') && $element->parent->type == 'column') {
    $attrs_item['uk-scrollspy-class'] = $element['item_animation'] ? "uk-animation-{$element['item_animation']}" : true;
}

// Max Width
$attrs_item['class'][] = $element['item_maxwidth'] ? "uk-width-{$element['item_maxwidth']} uk-margin-auto" : '';

// Container
$attrs_item['class'][] = 'uk-inline-clip';

// Mode
if ($element['overlay_mode'] == 'cover' && $element['overlay_style']) {
    $attrs_overlay['class'][] = "uk-position-cover";
    $attrs_overlay['class'][] = $element['overlay_margin'] ? "uk-position-{$element['overlay_margin']}" : '';
}

// Style
switch ($element['overlay_style']) {
    case '':
        $attrs_content['class'][] = 'uk-panel';
        break;
    default:
        $attrs_overlay['class'][] = "uk-{$element['overlay_style']}";
        $attrs_content['class'][] = 'uk-overlay';
}

// Padding
switch ($element['overlay_padding']) {
    case '':
        $attrs_content['class'][] = !$element['overlay_style'] ? 'uk-padding' : '';
        break;
    case 'none':
        $attrs_content['class'][] = $element['overlay_style'] ? 'uk-padding-remove' : '';
        break;
    default:
        $attrs_content['class'][] = "uk-padding-{$element['overlay_padding']}";
}

// Position
if (in_array($element['overlay_position'], ['center', 'top-center', 'bottom-center', 'center-left', 'center-right'])) {
    $attrs_center['class'][] = "uk-position-{$element['overlay_position']}";
    $attrs_center['class'][] = $element['overlay_margin'] && $element['overlay_style'] ? "uk-position-{$element['overlay_margin']}" : '';
} else {
    $attrs_content['class'][] = "uk-position-{$element['overlay_position']}";
    $attrs_content['class'][] = $element['overlay_margin'] && $element['overlay_style'] ? "uk-position-{$element['overlay_margin']}" : '';
}

// Width
if (!in_array($element['overlay_position'], ['cover', 'top', 'bottom'])) {
    $attrs_content['class'][] = $element['overlay_maxwidth'] ? "uk-width-{$element['overlay_maxwidth']}" : '';
}

// Transition
if ($element['overlay_hover'] || $element['image_transition'] || $item['image2']) {
    $attrs_item['class'][] = 'uk-transition-toggle';
}

if ($element['overlay_hover']) {

    if ($element['overlay_transition_background'] && ($element['overlay_mode'] == 'cover' && $element['overlay_style'])) {
        $attrs_overlay['class'][] = "uk-transition-{$element['overlay_transition']}";
    } else {
        $attrs_overlay['class'][] = "uk-transition-{$element['overlay_transition']}";
        $attrs_content['class'][] = "uk-transition-{$element['overlay_transition']}";
    }

}

// Text color
if (!$element['overlay_style'] || ($element['overlay_mode'] == 'cover' && $element['overlay_style'])) {
    $attrs_item['class'][] = $item['text_color'] ? "uk-{$item['text_color']}" : ($element['text_color'] ? "uk-{$element['text_color']}" : '');
}

// Inverse text color on hover
if ((!$element['overlay_style'] && $item['image2']) || ($element['overlay_mode'] == 'cover' && $element['overlay_style'] && $element['overlay_transition_background'])) {
    $attrs_item['uk-toggle'] = $item['text_color_hover'] || $element['text_color_hover'] ? "cls: uk-light uk-dark; mode: hover" : false;
}

// Image
if ($item['image']) {

    $attrs_image['alt'] = $item['image_alt'];

    // Transition
    if ($item['image2'])
        $attrs_image2['class'][] = $element['image_transition'] ? "uk-transition-{$element['image_transition']}" : 'uk-transition-fade';
    else {
        $attrs_image['class'][] = $element['image_transition'] ? "uk-transition-{$element['image_transition']} uk-transition-opaque" : '';
    }

    // Image
    if (pathinfo($item['image'], PATHINFO_EXTENSION) == 'svg') {
        $item['image'] = $this->image($item['image'], array_merge($attrs_image, ['width' => $element['image_width'], 'height' => $element['image_height']]));
    } elseif ($element['image_width'] || $element['image_height']) {
        $item['image'] = $this->image([$item['image'], 'thumbnail' => [$element['image_width'], $element['image_height']], 'sizes' => '80%,200%'], $attrs_image);
    } else {
        $item['image'] = $this->image($item['image'], $attrs_image);
    }

    // Image 2
    if ($item['image2']) {

        $attrs_image2['class'][] = 'uk-position-cover';

        if (pathinfo($item['image2'], PATHINFO_EXTENSION) == 'svg') {
            $item['image2'] = $this->image($item['image2'], array_merge($attrs_image2, ['width' => $element['image_width'], 'height' => $element['image_height']]));
        } elseif ($element['image_width'] || $element['image_height']) {
            $item['image2'] = $this->image([$item['image2'], 'thumbnail' => [$element['image_width'], $element['image_height']], 'sizes' => '80%,200%'], $attrs_image2);
        } else {
            $item['image2'] = $this->image($item['image2'], $attrs_image2);
        }

        $item['image'] .= $item['image2'];

    }

    // Box Shadow
    $attrs_item['class'][] = $element['image_box_shadow'] ? "uk-box-shadow-{$element['image_box_shadow']}" : '';
    $attrs_item['class'][] = $element['image_hover_box_shadow'] ? "uk-box-shadow-hover-{$element['image_hover_box_shadow']}" : '';

}

// Link
$attrs_link['href'] = $item['link'];
$attrs_link['target'] = $element['link_target'] ? '_blank' : '';
$attrs_link['uk-scroll'] = (strpos($item['link'], '#') === 0) ? true : false;
$attrs_link['class'][] = 'uk-position-cover';

?>

<div<?= $this->attrs($attrs_item) ?>>

    <?= $item['image'] ?>

    <?php if ($element['overlay_mode'] == 'cover' && $element['overlay_style']) : ?>
    <div<?= $this->attrs($attrs_overlay) ?>></div>
    <?php endif ?>

    <?php if ($item['title'] || $item['meta'] || $item['content']) : ?>

        <?php if ($attrs_center) : ?>
        <div<?= $this->attrs($attrs_center) ?>>
        <?php endif ?>

            <div<?= $this->attrs($attrs_content, !($element['overlay_mode'] == 'cover' && $element['overlay_style']) ? $attrs_overlay : []) ?>>
                <?= $this->render('@builder/gallery/template-content') ?>
            </div>

        <?php if ($attrs_center) : ?>
        </div>
        <?php endif ?>

    <?php endif ?>

    <?php if ($item['link']) : ?>
    <a<?= $this->attrs($attrs_link) ?>></a>
    <?php endif ?>

</div>
