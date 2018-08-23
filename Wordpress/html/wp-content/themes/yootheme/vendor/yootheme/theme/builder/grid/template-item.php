<?php

$attrs_item = [];
$attrs_content = [];
$attrs_image = [];
$attrs_grid = [];
$attrs_cell_image = [];
$attrs_image_container = [];
$attrs_link = [];
$attrs_icon = [];

// Display
if (!$element['show_title']) { $item['title'] = ''; }
if (!$element['show_meta']) { $item['meta'] = ''; }
if (!$element['show_content']) { $item['content'] = ''; }
if (!$element['show_image']) { $item['image'] = ''; }
if (!$element['show_link']) { $item['link'] = ''; }

// Animation
if ($element['item_animation'] != 'none' && $element->parent('section', 'animation') && $element->parent->type == 'column') {
    $attrs_item['uk-scrollspy-class'] = $element['item_animation'] ? "uk-animation-{$element['item_animation']}" : true;
}

// Max Width
$attrs_item['class'][] = $element['item_maxwidth'] ? "uk-width-{$element['item_maxwidth']} uk-margin-auto" : '';

// Image
if ($item['image']) {

    $src = $item['image'];

    $attrs_image['class'][] = $element['image_border'] ? "uk-border-{$element['image_border']}" : '';
    $attrs_image['class'][] = $element['image_box_shadow'] && !$element['panel_style'] ? "uk-box-shadow-{$element['image_box_shadow']}" : '';
    $attrs_image['class'][] = $item['link'] && $element['image_hover_box_shadow'] && !$element['panel_style'] && $element['link_style'] == 'panel' ? "uk-box-shadow-hover-{$element['image_hover_box_shadow']}" : '';
    $attrs_image['alt'] = $item['image_alt'];
    $attrs_image['uk-cover'] = ($element['panel_style'] && $element['image_card'] && in_array($element['image_align'], ['left', 'right'])) ? true : false;

    if (pathinfo($item['image'], PATHINFO_EXTENSION) == 'svg') {
        $item['image'] = $this->image($src, array_merge($attrs_image, ['width' => $element['image_width'], 'height' => $element['image_height']]));
    } elseif ($element['image_width'] || $element['image_height']) {
        $item['image'] = $this->image([$src, 'thumbnail' => [$element['image_width'], $element['image_height']], 'sizes' => '80%,200%'], $attrs_image);
    } else {
        $item['image'] = $this->image($src, $attrs_image);
    }

    // Placeholder image if card and layout left or right
    if ($element['panel_style'] && $element['image_card'] && in_array($element['image_align'], ['left', 'right'])) {
        $attrs_image['class'][] = 'uk-invisible';
        $attrs_image['uk-cover'] = false;
        if ($element['image_width'] || $element['image_height']) {
            $item['image'] .= $this->image([$src, 'thumbnail' => [$element['image_width'], $element['image_height']], 'sizes' => '80%,200%'], $attrs_image);
        } else {
            $item['image'] .= $this->image($src, $attrs_image);
        }
    }

} elseif ($item['icon']) {

    $options = ["icon: {$item['icon']}"];
    $options[] = $element['icon_ratio'] ? "ratio: {$element['icon_ratio']}" : '';
    $attrs_icon['uk-icon'] = implode(';', array_filter($options));

    $attrs_icon['class'][] = $element['icon_color'] ? "uk-text-{$element['icon_color']}" : '';

    $item['image'] = "<span {$this->attrs($attrs_icon)}></span>";
    $element['image_card'] = false;

}

// Card
if ($element['panel_style']) {

    $attrs_item['class'][] = "uk-card uk-{$element['panel_style']}";
    $attrs_item['class'][] = $element['panel_size'] ? "uk-card-{$element['panel_size']}" : '';
    $attrs_item['class'][] = $item['link'] && $element['link_style'] == 'panel' && $element['panel_style'] != 'card-hover' ? 'uk-card-hover' : '';

    // Card media
    if ($item['image'] && $element['image_card'] && $element['image_align'] != 'between') {
        $attrs_content['class'][] = 'uk-card-body';
    } else {
        $attrs_item['class'][] = 'uk-card-body';
    }

} else {
    $attrs_item['class'][] = 'uk-panel';
}

// Image Align
$attrs_grid['class'][] = 'uk-child-width-expand';

if ($element['panel_style'] && $element['image_card']) {
    $attrs_grid['class'][] = 'uk-grid-collapse uk-grid-match';
} else {
    $attrs_grid['class'][] = $element['image_gutter'] ? "uk-grid-{$element['image_gutter']}" : '';
}

$attrs_grid['class'][] = $element['image_vertical_align'] ? 'uk-flex-middle' : '';
$attrs_grid['uk-grid'] = true;

$attrs_cell_image['class'][] = "uk-width-{$element['image_grid_width']}@{$element['image_breakpoint']}";
$attrs_cell_image['class'][] = $element['image_align'] == 'right' ? "uk-flex-last@{$element['image_breakpoint']}" : '';

if ($element['panel_style'] && $element['image_card'] && in_array($element['image_align'], ['left', 'right'])) {
    $attrs_image_container['class'][] = 'uk-cover-container';
}

// Card media
if ($element['panel_style'] && $item['image'] && $element['image_card'] && $element['image_align'] != 'between' ) {
    $attrs_image_container['class'][] = "uk-card-media-{$element['image_align']}";
    $item['image'] = "<div{$this->attrs($attrs_image_container)}>{$item['image']}</div>";
}

// Link
if ($item['link']) {

    $attrs_link['href'] = $item['link'];
    $attrs_link['target'] = $element['link_target'] ? '_blank' : '';
    $attrs_link['uk-scroll'] = (strpos($item['link'], '#') === 0) ? true : false;

    if ($element['link_style'] == 'panel') {

        if ($element['panel_style']) {
            $attrs_link['class'][] = 'uk-position-cover uk-margin-remove-adjacent';
        }

        if (!$element['panel_style'] && $item['image']) {
            $item['image'] = "<a{$this->attrs($attrs_link)}>{$item['image']}</a>";
        }

    } else {

        switch ($element['link_style']) {
            case '':
                break;
            case 'link-muted':
                $attrs_link['class'][] = "uk-{$element['link_style']}";
                break;
            default:
                $attrs_link['class'][] = "uk-button uk-button-{$element['link_style']}";
                $attrs_link['class'][] = $element['link_size'] ? "uk-button-{$element['link_size']}" : '';
        }

    }

}

?>

<div<?= $this->attrs($attrs_item) ?>>

    <?php if ($item['link'] && $element['link_style'] == 'panel' && $element['panel_style']) : ?>
    <a<?= $this->attrs($attrs_link) ?>></a>
    <?php endif ?>

    <?php if ($item['image'] && in_array($element['image_align'], ['left', 'right'])) : ?>

        <div<?= $this->attrs($attrs_grid) ?>>
            <div<?= $this->attrs($attrs_cell_image) ?>>
                <?= $item['image'] ?>
            </div>
            <div>

                <?php if ($element['panel_style'] && $item['image']) : ?>
                    <div<?= $this->attrs($attrs_content) ?>>
                        <?= $this->render('@builder/grid/template-content', compact('item', 'attrs_link')) ?>
                    </div>
                <?php else : ?>
                    <?= $this->render('@builder/grid/template-content', compact('item', 'attrs_link')) ?>
                <?php endif ?>

            </div>
        </div>

    <?php else : ?>

        <?php if ($element['image_align'] == 'top') : ?>
        <?= $item['image'] ?>
        <?php endif ?>

        <?php if ($element['panel_style'] && $item['image'] && $element['image_card'] && in_array($element['image_align'], ['top', 'bottom'])) : ?>
            <div<?= $this->attrs($attrs_content) ?>>
                <?= $this->render('@builder/grid/template-content', compact('item', 'attrs_link')) ?>
            </div>
        <?php else : ?>
            <?= $this->render('@builder/grid/template-content', compact('item', 'attrs_link')) ?>
        <?php endif ?>

        <?php if ($element['image_align'] == 'bottom') : ?>
        <?= $item['image'] ?>
        <?php endif ?>

    <?php endif ?>

</div>
